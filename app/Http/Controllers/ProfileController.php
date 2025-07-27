<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Load customer data if user is a customer
        if ($user->isCustomer() && $user->kd_pelanggan) {
            $user->load('customer');
        }

        // Get user activity stats
        $stats = $this->getUserStats($user);

        return view('profile.edit', compact('user', 'stats'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = $request->user();
            $validated = $request->validated();

            // Update basic user info
            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Update customer info if user is a customer
            if ($user->isCustomer() && $user->kd_pelanggan && $request->has('customer_info')) {
                $customerData = $request->input('customer_info');
                $user->customer->update($customerData);
            }

            DB::commit();

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Profile update failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        try {
            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);

            Log::info('Password updated', ['user_id' => $request->user()->id]);

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            Log::error('Password update failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to update password. Please try again.');
        }
    }

    /**
     * Show user activity and stats
     */
    public function activity(Request $request): View
    {
        $user = $request->user();
        $stats = $this->getUserStats($user);
        
        // Get recent activities based on user type
        $recentActivities = $this->getRecentActivities($user);

        return view('profile.activity', compact('user', 'stats', 'recentActivities'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        try {
            DB::beginTransaction();

            $user = $request->user();

            // For customers, don't delete if they have sales history
            if ($user->isCustomer() && $user->sales()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete account with existing purchase history. Please contact admin.');
            }

            // For staff, check if they have created sales/purchases
            if (($user->isAdmin() || $user->isPharmacist()) && 
                ($user->sales()->count() > 0 || $user->purchases()->count() > 0)) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete account with existing transaction history. Please contact admin.');
            }

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            DB::commit();

            return redirect()->to('/')->with('success', 'Account deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Account deletion failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to delete account. Please try again.');
        }
    }

    /**
     * Get user statistics based on role
     */
    private function getUserStats($user): array
    {
        $stats = [
            'account_created' => $user->created_at,
            'last_login' => $user->updated_at, // Approximation
            'total_logins' => 0, // Would need login tracking
        ];

        if ($user->isCustomer()) {
            // Get customer's online orders
            $customerOrders = Sale::where('kd_pelanggan', $user->kd_pelanggan)
                ->where('tipe_transaksi', 'online');
                
            $stats['total_purchases'] = $customerOrders->count();
            $stats['total_spent'] = $customerOrders->sum('total_harga') ?: $customerOrders->sum('total_after_discount');
            $stats['recent_purchases'] = $customerOrders->latest()->limit(5)->get();
            $stats['pending_orders'] = $customerOrders->where('status_pesanan', 'pending')->count();
            $stats['completed_orders'] = $customerOrders->where('status_pesanan', 'completed')->count();
        }

        if ($user->isPharmacist() || $user->isAdmin()) {
            $stats['sales_processed'] = $user->sales()->count();
            $stats['purchases_created'] = $user->purchases()->count();
            $stats['total_sales_value'] = $user->sales()->sum('total_after_discount');
            $stats['total_purchases_value'] = $user->purchases()->sum('total_after_discount');
        }

        return $stats;
    }

    /**
     * Get recent user activities
     */
    private function getRecentActivities($user): array
    {
        $activities = [];

        if ($user->isCustomer()) {
            // Recent purchases - get online orders by customer code
            $recentSales = Sale::where('kd_pelanggan', $user->kd_pelanggan)
                ->where('tipe_transaksi', 'online')
                ->with(['details.drug'])
                ->latest()
                ->limit(10)
                ->get();
                
            foreach ($recentSales as $sale) {
                $activities[] = [
                    'type' => 'purchase',
                    'description' => "Ordered {$sale->details->count()} items online",
                    'amount' => $sale->total_harga ?? $sale->total_after_discount,
                    'date' => $sale->created_at,
                    'details' => $sale,
                    'status' => $sale->status_pesanan ?? 'completed',
                    'order_number' => $sale->no_faktur ?? $sale->nota
                ];
            }
        }

        if ($user->isPharmacist() || $user->isAdmin()) {
            // Recent sales processed
            $recentSales = $user->sales()->latest()->limit(5)->get();
            foreach ($recentSales as $sale) {
                $activities[] = [
                    'type' => 'sale_processed',
                    'description' => "Processed sale {$sale->nota}",
                    'amount' => $sale->total_after_discount,
                    'date' => $sale->created_at
                ];
            }

            // Recent purchases created
            $recentPurchases = $user->purchases()->latest()->limit(5)->get();
            foreach ($recentPurchases as $purchase) {
                $activities[] = [
                    'type' => 'purchase_created',
                    'description' => "Created purchase order {$purchase->nota}",
                    'amount' => $purchase->total_after_discount,
                    'date' => $purchase->created_at
                ];
            }
        }

        // Sort by date
        usort($activities, function($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });

        return array_slice($activities, 0, 15); // Return latest 15 activities
    }
}
