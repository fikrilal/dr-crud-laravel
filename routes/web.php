<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CatalogController;
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
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    
    Route::get('/suppliers', function () {
        return view('admin.suppliers.index');
    })->name('suppliers.index');
    
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
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{drug}', [CatalogController::class, 'show'])->name('catalog.show');
    
    Route::get('/orders', function () {
        return view('customer.orders.index');
    })->name('orders.index');
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
