<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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
});

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

// Pharmacist Routes
Route::middleware(['auth', 'pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/drugs', function () {
        return view('pharmacist.drugs.index');
    })->name('drugs.index');
    
    Route::get('/sales', function () {
        return view('pharmacist.sales.index');
    })->name('sales.index');
    
    Route::get('/purchases', function () {
        return view('pharmacist.purchases.index');
    })->name('purchases.index');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/catalog', function () {
        return view('customer.catalog.index');
    })->name('catalog.index');
    
    Route::get('/orders', function () {
        return view('customer.orders.index');
    })->name('orders.index');
});

// Shared authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
