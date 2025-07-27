<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Drug;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->get('date_range', '30'); // Default 30 days
        $startDate = Carbon::now()->subDays($dateRange);
        $endDate = Carbon::now();
        
        // Overview Stats
        $overview = $this->getOverviewStats();
        
        // Sales Analytics
        $salesAnalytics = $this->getSalesAnalytics($startDate, $endDate);
        
        // Inventory Analytics
        $inventoryAnalytics = $this->getInventoryAnalytics();
        
        // User Analytics
        $userAnalytics = $this->getUserAnalytics($startDate, $endDate);
        
        // Order Analytics
        $orderAnalytics = $this->getOrderAnalytics($startDate, $endDate);
        
        // Financial Analytics
        $financialAnalytics = $this->getFinancialAnalytics($startDate, $endDate);
        
        // Performance Analytics
        $performanceAnalytics = $this->getPerformanceAnalytics($startDate, $endDate);
        
        return view('admin.reports.index', compact(
            'overview',
            'salesAnalytics',
            'inventoryAnalytics',
            'userAnalytics',
            'orderAnalytics',
            'financialAnalytics',
            'performanceAnalytics',
            'dateRange'
        ));
    }
    
    private function getOverviewStats()
    {
        return [
            'total_drugs' => Drug::count(),
            'total_users' => User::count(),
            'total_customers' => User::where('user_type', 'customer')->count(),
            'total_suppliers' => Supplier::count(),
            'total_sales' => Sale::count(),
            'total_purchases' => Purchase::count(),
            'active_drugs' => Drug::where('status', 'active')->count(),
            'low_stock_drugs' => Drug::where('status', 'active')->where('stok', '<=', 10)->count(),
        ];
    }
    
    private function getSalesAnalytics($startDate, $endDate)
    {
        $totalSales = Sale::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_after_discount');
        
        $onlineSales = Sale::where('tipe_transaksi', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        $offlineSales = Sale::where('tipe_transaksi', '!=', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        // Daily sales trend
        $dailySales = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_after_discount) as revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top selling drugs
        $topDrugs = DB::table('sale_details')
            ->join('sales', 'sale_details.nota', '=', 'sales.nota')
            ->join('drugs', 'sale_details.kd_obat', '=', 'drugs.kd_obat')
            ->select(
                'drugs.nm_obat',
                DB::raw('SUM(sale_details.jumlah) as total_quantity'),
                DB::raw('SUM(sale_details.subtotal) as total_revenue')
            )
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('drugs.kd_obat', 'drugs.nm_obat')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();
        
        return [
            'total_sales' => $totalSales,
            'total_revenue' => $totalRevenue,
            'online_sales' => $onlineSales,
            'offline_sales' => $offlineSales,
            'average_order_value' => $totalSales > 0 ? $totalRevenue / $totalSales : 0,
            'daily_sales' => $dailySales,
            'top_drugs' => $topDrugs,
        ];
    }
    
    private function getInventoryAnalytics()
    {
        $totalDrugs = Drug::count();
        $activeDrugs = Drug::where('status', 'active')->count();
        $inactiveDrugs = Drug::where('status', 'inactive')->count();
        
        $lowStockDrugs = Drug::where('status', 'active')
            ->where('stok', '<=', 10)
            ->get();
        
        $outOfStockDrugs = Drug::where('status', 'active')
            ->where('stok', '<=', 0)
            ->get();
        
        $totalInventoryValue = Drug::where('status', 'active')
            ->sum(DB::raw('stok * harga_jual'));
        
        // Stock distribution by category
        $stockByCategory = Drug::select('jenis', DB::raw('COUNT(*) as count'))
            ->where('status', 'active')
            ->groupBy('jenis')
            ->get();
        
        // Recently added drugs
        $recentDrugs = Drug::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return [
            'total_drugs' => $totalDrugs,
            'active_drugs' => $activeDrugs,
            'inactive_drugs' => $inactiveDrugs,
            'low_stock_count' => $lowStockDrugs->count(),
            'out_of_stock_count' => $outOfStockDrugs->count(),
            'low_stock_drugs' => $lowStockDrugs,
            'out_of_stock_drugs' => $outOfStockDrugs,
            'total_inventory_value' => $totalInventoryValue,
            'stock_by_category' => $stockByCategory,
            'recent_drugs' => $recentDrugs,
        ];
    }
    
    private function getUserAnalytics($startDate, $endDate)
    {
        $totalUsers = User::count();
        $adminCount = User::where('user_type', 'admin')->count();
        $pharmacistCount = User::where('user_type', 'pharmacist')->count();
        $customerCount = User::where('user_type', 'customer')->count();
        
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();
        
        // New registrations in period
        $newRegistrations = User::whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Customer registration trend
        $customerRegistrations = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('user_type', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Most active customers (by order count)
        $activeCustomers = DB::table('sales')
            ->join('users', 'sales.kd_pelanggan', '=', 'users.kd_pelanggan')
            ->select(
                'users.name',
                'users.email',
                DB::raw('COUNT(sales.nota) as order_count'),
                DB::raw('SUM(sales.total_after_discount) as total_spent')
            )
            ->where('sales.tipe_transaksi', 'online')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('order_count', 'desc')
            ->limit(10)
            ->get();
        
        return [
            'total_users' => $totalUsers,
            'admin_count' => $adminCount,
            'pharmacist_count' => $pharmacistCount,
            'customer_count' => $customerCount,
            'active_users' => $activeUsers,
            'inactive_users' => $inactiveUsers,
            'new_registrations' => $newRegistrations,
            'customer_registrations' => $customerRegistrations,
            'active_customers' => $activeCustomers,
        ];
    }
    
    private function getOrderAnalytics($startDate, $endDate)
    {
        $totalOrders = Sale::where('tipe_transaksi', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        $pendingOrders = Sale::where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        $confirmedOrders = Sale::where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        $completedOrders = Sale::where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        $rejectedOrders = Sale::where('tipe_transaksi', 'online')
            ->where('status_pesanan', 'rejected')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        // Order status distribution
        $orderStatusDistribution = Sale::select(
                'status_pesanan',
                DB::raw('COUNT(*) as count')
            )
            ->where('tipe_transaksi', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status_pesanan')
            ->get();
        
        // Payment method distribution
        $paymentMethods = Sale::select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_after_discount) as total_amount')
            )
            ->where('tipe_transaksi', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get();
        
        return [
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'confirmed_orders' => $confirmedOrders,
            'completed_orders' => $completedOrders,
            'rejected_orders' => $rejectedOrders,
            'completion_rate' => $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0,
            'order_status_distribution' => $orderStatusDistribution,
            'payment_methods' => $paymentMethods,
        ];
    }
    
    private function getFinancialAnalytics($startDate, $endDate)
    {
        $totalRevenue = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_after_discount');
        
        $onlineRevenue = Sale::where('tipe_transaksi', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_after_discount');
        
        $offlineRevenue = Sale::where('tipe_transaksi', '!=', 'online')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_after_discount');
        
        $totalPurchaseCost = Purchase::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_after_discount');
        
        // Monthly revenue trend
        $monthlyRevenue = Sale::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_after_discount) as revenue'),
                DB::raw('COUNT(*) as order_count')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        return [
            'total_revenue' => $totalRevenue,
            'online_revenue' => $onlineRevenue,
            'offline_revenue' => $offlineRevenue,
            'total_purchase_cost' => $totalPurchaseCost,
            'gross_profit' => $totalRevenue - $totalPurchaseCost,
            'profit_margin' => $totalRevenue > 0 ? (($totalRevenue - $totalPurchaseCost) / $totalRevenue) * 100 : 0,
            'monthly_revenue' => $monthlyRevenue,
        ];
    }
    
    private function getPerformanceAnalytics($startDate, $endDate)
    {
        // Best performing pharmacists
        $topPharmacists = User::select(
                'users.name',
                DB::raw('COUNT(sales.nota) as sales_count'),
                DB::raw('SUM(sales.total_after_discount) as total_revenue')
            )
            ->join('sales', 'users.id', '=', 'sales.user_id')
            ->where('users.user_type', 'pharmacist')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();
        
        // Supplier performance
        $supplierPerformance = Supplier::select(
                'suppliers.nm_supplier',
                DB::raw('COUNT(purchases.nota) as purchase_count'),
                DB::raw('SUM(purchases.total_after_discount) as total_amount')
            )
            ->join('purchases', 'suppliers.kd_supplier', '=', 'purchases.kd_supplier')
            ->whereBetween('purchases.created_at', [$startDate, $endDate])
            ->groupBy('suppliers.kd_supplier', 'suppliers.nm_supplier')
            ->orderBy('purchase_count', 'desc')
            ->limit(5)
            ->get();
        
        // System performance metrics
        $avgOrderProcessingTime = 2.5; // Mock data - could be calculated from order timestamps
        $customerSatisfactionRate = 94.2; // Mock data - could come from reviews/ratings
        
        return [
            'top_pharmacists' => $topPharmacists,
            'supplier_performance' => $supplierPerformance,
            'avg_order_processing_time' => $avgOrderProcessingTime,
            'customer_satisfaction_rate' => $customerSatisfactionRate,
        ];
    }
    
    public function export(Request $request)
    {
        $type = $request->get('type', 'sales');
        $format = $request->get('format', 'csv');
        
        // This would implement export functionality
        // For now, return a simple response
        return response()->json([
            'success' => true,
            'message' => "Export functionality for {$type} in {$format} format would be implemented here"
        ]);
    }
}