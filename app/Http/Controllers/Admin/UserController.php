<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // Debug: Log incoming request
        \Log::info('User creation request received', [
            'request_data' => $request->all(),
            'user_type' => $request->user_type,
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        // Prepare validation rules based on user type
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'in:admin,pharmacist,customer'],
            'is_active' => ['boolean'],
        ];

        // Only add customer validation rules if user_type is customer
        if ($request->user_type === 'customer') {
            $validationRules = array_merge($validationRules, [
                'customer_name' => ['required', 'string', 'max:255'],
                'customer_phone' => ['required', 'string', 'max:20'],
                'customer_address' => ['required', 'string', 'max:500'],
                'customer_city' => ['required', 'string', 'max:100'],
                'customer_email' => ['nullable', 'email', 'max:255'],
                'birth_date' => ['nullable', 'date'],
                'gender' => ['nullable', 'in:L,P'],
            ]);
        }

        $request->validate($validationRules);
        
        \Log::info('Validation passed for user creation');

        try {
            DB::beginTransaction();
            
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'is_active' => $request->boolean('is_active', true),
            ];
            
            \Log::info('User data prepared', ['user_data' => array_merge($userData, ['password' => '[HIDDEN]'])]);
            
            // If creating a customer, generate customer code and set it
            if ($request->user_type === 'customer') {
                $lastCustomer = Customer::orderBy('kd_pelanggan', 'desc')->first();
                $nextNumber = $lastCustomer 
                    ? (int)substr($lastCustomer->kd_pelanggan, 2) + 1 
                    : 1;
                $customerCode = 'CS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                
                $userData['kd_pelanggan'] = $customerCode;
                
                \Log::info('Creating customer record', ['customer_code' => $customerCode]);
                
                // Create the customer record
                $customer = Customer::create([
                    'kd_pelanggan' => $customerCode,
                    'nm_pelanggan' => $request->customer_name,
                    'telpon' => $request->customer_phone,
                    'alamat' => $request->customer_address,
                    'kota' => $request->customer_city,
                    'email' => $request->customer_email,
                    'tanggal_lahir' => $request->birth_date,
                    'jenis_kelamin' => $request->gender,
                ]);
                
                \Log::info('Customer record created', ['customer_id' => $customer->id]);
            }
            
            $user = User::create($userData);
            \Log::info('User created successfully', ['user_id' => $user->id, 'user_type' => $user->user_type]);
            
            DB::commit();
            
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User created successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('User creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'user_type' => ['required', 'in:admin,pharmacist,customer'],
            'is_active' => ['boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
        
        // Add customer-specific validation if user is a customer
        if ($user->user_type === 'customer') {
            $validationRules = array_merge($validationRules, [
                'customer_name' => ['required', 'string', 'max:255'],
                'customer_phone' => ['required', 'string', 'max:20'],
                'customer_address' => ['required', 'string', 'max:500'],
                'customer_city' => ['required', 'string', 'max:100'],
                'customer_email' => ['nullable', 'email', 'max:255'],
                'birth_date' => ['nullable', 'date'],
                'gender' => ['nullable', 'in:L,P'],
            ]);
        }
        
        $request->validate($validationRules);
        
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
            
            // Update customer data if user is a customer
            if ($user->user_type === 'customer' && $user->customer) {
                $user->customer->update([
                    'nm_pelanggan' => $request->customer_name,
                    'telpon' => $request->customer_phone,
                    'alamat' => $request->customer_address,
                    'kota' => $request->customer_city,
                    'email' => $request->customer_email,
                    'tanggal_lahir' => $request->birth_date,
                    'jenis_kelamin' => $request->gender,
                ]);
            }
            
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
        Log::info('Delete user request initiated', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_type' => $user->user_type,
            'requested_by' => auth()->id()
        ]);

        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            Log::warning('User attempted to delete own account', [
                'user_id' => $user->id
            ]);
            
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }
        
        // Check if user has transaction history
        $salesCount = $user->sales()->count();
        $purchasesCount = $user->purchases()->count();
        
        Log::info('Checking user transaction history', [
            'user_id' => $user->id,
            'sales_count' => $salesCount,
            'purchases_count' => $purchasesCount
        ]);
        
        if ($salesCount > 0 || $purchasesCount > 0) {
            Log::warning('Cannot delete user with transaction history', [
                'user_id' => $user->id,
                'sales_count' => $salesCount,
                'purchases_count' => $purchasesCount
            ]);
            
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete user with existing transaction history.');
        }
        
        // For customers, check if they have online orders
        $customerOrdersCount = 0;
        if ($user->isCustomer() && $user->kd_pelanggan) {
            $customerOrdersCount = \App\Models\Sale::where('kd_pelanggan', $user->kd_pelanggan)
                ->where('tipe_transaksi', 'online')
                ->count();
            
            Log::info('Checking customer order history', [
                'user_id' => $user->id,
                'kd_pelanggan' => $user->kd_pelanggan,
                'customer_orders_count' => $customerOrdersCount
            ]);
            
            if ($customerOrdersCount > 0) {
                Log::warning('Cannot delete customer with order history', [
                    'user_id' => $user->id,
                    'customer_orders_count' => $customerOrdersCount
                ]);
                
                return redirect()
                    ->route('admin.users.index')
                    ->with('error', 'Cannot delete customer with existing order history.');
            }
        }
        
        try {
            DB::beginTransaction();
            
            $userName = $user->name;
            $userType = $user->user_type;
            
            // If customer, delete customer record first
            if ($user->isCustomer() && $user->customer) {
                Log::info('Deleting customer record', [
                    'user_id' => $user->id,
                    'customer_id' => $user->customer->id
                ]);
                $user->customer->delete();
            }
            
            $user->delete();
            
            Log::info('User successfully deleted', [
                'user_id' => $user->id,
                'user_name' => $userName,
                'user_type' => $userType
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('admin.users.index')
                ->with('success', "User '{$userName}' has been successfully deleted!");
                
        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Failed to delete user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
    
    public function toggleStatus(User $user)
    {
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