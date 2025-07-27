<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Drug;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        switch ($user->user_type) {
            case 'admin':
                return $this->adminDashboard();
            case 'pharmacist':
                return $this->pharmacistDashboard();
            case 'customer':
                return $this->customerDashboard();
            default:
                abort(403, 'Invalid user type');
        }
    }

    private function adminDashboard()
    {
        // Get real-time admin statistics
        $stats = $this->getAdminStats();
        
        return view('dashboards.admin', [
            'title' => 'Admin Dashboard',
            'user' => auth()->user(),
            'stats' => $stats
        ]);
    }

    private function pharmacistDashboard()
    {
        // Get real-time pharmacist statistics
        $stats = $this->getPharmacistStats();
        
        return view('dashboards.pharmacist', [
            'title' => 'Pharmacist Dashboard',
            'user' => auth()->user(),
            'stats' => $stats
        ]);
    }

    private function customerDashboard()
    {
        // Get real-time customer statistics
        $stats = $this->getCustomerStats();
        
        return view('dashboards.customer', [
            'title' => 'Customer Dashboard',
            'user' => auth()->user(),
            'stats' => $stats
        ]);
    }
    
    private function getAdminStats()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        
        // Total users and growth
        $totalUsers = User::count();
        $lastMonthUsers = User::where('created_at', '<=', $lastMonthEnd)->count();
        $userGrowth = $lastMonthUsers > 0 ? (($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 0;
        
        // Total revenue and growth
        $totalRevenue = Sale::sum('total_after_discount');
        $currentMonthRevenue = Sale::where('created_at', '>=', $currentMonth)->sum('total_after_discount');
        $lastMonthRevenue = Sale::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('total_after_discount');
        $revenueGrowth = $lastMonthRevenue > 0 ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;
        
        // Low stock items
        $lowStockItems = Drug::where('status', 'active')->where('stok', '<=', 10)->count();
        
        // Expiring soon (using same logic as ExpiryAlertController)
        $criticalDate = Carbon::now()->subMonths(22); // Drugs created 22+ months ago
        $expiringSoon = Drug::where('status', 'active')
            ->where('created_at', '<=', $criticalDate)
            ->count();
        
        // Additional quick stats
        $todaySales = Sale::whereDate('created_at', Carbon::today())->count();
        $pendingOrders = Sale::where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'pending')
            ->count();
        $totalDrugs = Drug::where('status', 'active')->count();
        $totalSuppliers = Supplier::count();
        
        // Recent activities
        $recentSales = Sale::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $recentUsers = User::where('user_type', 'customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return [
            'total_users' => $totalUsers,
            'user_growth' => $userGrowth,
            'total_revenue' => $totalRevenue,
            'revenue_growth' => $revenueGrowth,
            'low_stock_items' => $lowStockItems,
            'expiring_soon' => $expiringSoon,
            'today_sales' => $todaySales,
            'pending_orders' => $pendingOrders,
            'total_drugs' => $totalDrugs,
            'total_suppliers' => $totalSuppliers,
            'recent_sales' => $recentSales,
            'recent_users' => $recentUsers,
        ];
    }
    
    private function getPharmacistStats()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        
        // Today's sales
        $todaySales = Sale::whereDate('created_at', $today)->count();
        $todayRevenue = Sale::whereDate('created_at', $today)->sum('total_after_discount');
        
        // This week's performance
        $weekSales = Sale::where('created_at', '>=', $thisWeek)->count();
        $weekRevenue = Sale::where('created_at', '>=', $thisWeek)->sum('total_after_discount');
        
        // Inventory alerts
        $lowStockCount = Drug::where('status', 'active')->where('stok', '<=', 10)->count();
        $outOfStockCount = Drug::where('status', 'active')->where('stok', '<=', 0)->count();
        
        // Pending orders to process
        $pendingOrders = Sale::where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'pending')
            ->count();
        
        // Recent activities
        $recentSales = Sale::orderBy('created_at', 'desc')->limit(5)->get();
        $lowStockDrugs = Drug::where('status', 'active')
            ->where('stok', '<=', 10)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();
        
        return [
            'today_sales' => $todaySales,
            'today_revenue' => $todayRevenue,
            'week_sales' => $weekSales,
            'week_revenue' => $weekRevenue,
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            'pending_orders' => $pendingOrders,
            'recent_sales' => $recentSales,
            'low_stock_drugs' => $lowStockDrugs,
        ];
    }
    
    private function getCustomerStats()
    {
        $customer = auth()->user();
        
        // Customer's order history
        $totalOrders = Sale::where('kd_pelanggan', $customer->kd_pelanggan)->count();
        $totalSpent = Sale::where('kd_pelanggan', $customer->kd_pelanggan)->sum('total_after_discount');
        
        // Recent orders
        $recentOrders = Sale::where('kd_pelanggan', $customer->kd_pelanggan)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Pending orders
        $pendingOrders = Sale::where('kd_pelanggan', $customer->kd_pelanggan)
            ->where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'pending')
            ->count();
        
        // Available drugs count
        $availableDrugs = Drug::where('status', 'active')->where('stok', '>', 0)->count();
        
        // Cart items count
        $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
        
        return [
            'total_orders' => $totalOrders,
            'total_spent' => $totalSpent,
            'recent_orders' => $recentOrders,
            'pending_orders' => $pendingOrders,
            'available_drugs' => $availableDrugs,
            'cart_count' => $cartCount,
        ];
    }
}
