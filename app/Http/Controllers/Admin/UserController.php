<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('customer');
        
        // Filter by user type
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get stats for dashboard
        $stats = [
            'total_users' => User::count(),
            'admin_count' => User::where('user_type', 'admin')->count(),
            'pharmacist_count' => User::where('user_type', 'pharmacist')->count(),
            'customer_count' => User::where('user_type', 'customer')->count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }
    
    public function show(User $user)
    {
        $user->load('customer');
        
        // Get user activity stats
        $stats = [
            'total_sales' => $user->sales()->count(),
            'total_purchases' => $user->purchases()->count(),
            'account_age' => $user->created_at->diffInDays(now()),
            'last_activity' => $user->updated_at,
        ];
        
        return view('admin.users.show', compact('user', 'stats'));
    }
    
    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'in:admin,pharmacist'],
            'is_active' => ['boolean'],
        ]);
        
        try {
            DB::beginTransaction();
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'is_active' => $request->boolean('is_active', true),
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User created successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create user. Please try again.');
        }
    }
    
    public function edit(User $user)
    {
        // Only allow editing admin and pharmacist accounts
        if ($user->user_type === 'customer') {
            return redirect()
                ->route('admin.users.show', $user)
                ->with('error', 'Customer accounts cannot be edited from this interface.');
        }
        
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        // Only allow updating admin and pharmacist accounts
        if ($user->user_type === 'customer') {
            return redirect()
                ->route('admin.users.show', $user)
                ->with('error', 'Customer accounts cannot be modified.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'user_type' => ['required', 'in:admin,pharmacist'],
            'is_active' => ['boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        try {
            DB::beginTransaction();
            
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'user_type' => $request->user_type,
                'is_active' => $request->boolean('is_active', true),
            ];
            
            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);
            
            DB::commit();
            
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }
    
    public function destroy(User $user)
    {
        // Only allow deleting admin and pharmacist accounts
        if ($user->user_type === 'customer') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Customer accounts cannot be deleted from this interface.');
        }
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }
        
        // Check if user has transaction history
        if ($user->sales()->count() > 0 || $user->purchases()->count() > 0) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete user with existing transaction history.');
        }
        
        try {
            DB::beginTransaction();
            
            $user->delete();
            
            DB::commit();
            
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Failed to delete user. Please try again.');
        }
    }
    
    public function toggleStatus(User $user)
    {
        // Only allow status changes for admin and pharmacist accounts
        if ($user->user_type === 'customer') {
            return response()->json(['error' => 'Customer account status cannot be changed'], 403);
        }
        
        // Prevent deactivating own account
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'You cannot deactivate your own account'], 403);
        }
        
        try {
            $user->update(['is_active' => !$user->is_active]);
            
            $status = $user->is_active ? 'activated' : 'deactivated';
            
            return response()->json([
                'success' => true,
                'message' => "User {$status} successfully!",
                'status' => $user->is_active
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user status'], 500);
        }
    }
}