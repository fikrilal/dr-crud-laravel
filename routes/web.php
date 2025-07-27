<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\OrderManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Role-based Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    
    // Supplier Management (reuse existing controller)
    Route::resource('suppliers', SupplierController::class);
    
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('reports.index');
});

// Drug Management Routes (Admin & Pharmacist)
Route::middleware(['auth'])->group(function () {
    Route::resource('drugs', DrugController::class);
    Route::get('/api/drugs/search', [DrugController::class, 'search'])->name('drugs.search');
    Route::patch('/drugs/{drug}/stock', [DrugController::class, 'updateStock'])->name('drugs.updateStock');
});

// Supplier Management Routes (Admin & Pharmacist)
Route::middleware(['auth'])->group(function () {
    Route::resource('suppliers', SupplierController::class);
    Route::get('/api/suppliers/search', [SupplierController::class, 'search'])->name('suppliers.search');
});

// Sales Management Routes (Admin & Pharmacist)
Route::middleware(['auth'])->group(function () {
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/api/sales/drug/{drug}', [SaleController::class, 'getDrug'])->name('sales.getDrug');
    Route::post('/api/sales/customer', [SaleController::class, 'createQuickCustomer'])->name('sales.createCustomer');
    Route::get('/api/sales/stats', [SaleController::class, 'getStats'])->name('sales.stats');
    Route::get('/sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
});

// Purchase Management Routes (Admin & Pharmacist)
Route::middleware(['auth'])->group(function () {
    Route::resource('purchases', PurchaseController::class);
    Route::post('/purchases/{purchase}/receive', [PurchaseController::class, 'receive'])->name('purchases.receive');
    Route::post('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
});

// Order Management Routes (Admin & Pharmacist)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderManagementController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [OrderManagementController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/reject', [OrderManagementController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/payment', [OrderManagementController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');
});

// Pharmacist Routes
Route::middleware(['auth', 'pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/sales', function () {
        return view('pharmacist.sales.index');
    })->name('sales.index');
    
    Route::get('/purchases', function () {
        return view('pharmacist.purchases.index');
    })->name('purchases.index');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    // Catalog
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{drug}', [CatalogController::class, 'show'])->name('catalog.show');
    
    // Cart & Orders
    Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order', [OrderController::class, 'placeOrder'])->name('order.place');
    
    // Order History
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'showOrder'])->name('orders.show');
});

// Shared authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/activity', [ProfileController::class, 'activity'])->name('profile.activity');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
