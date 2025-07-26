# Dr. CRUD - Laravel Pharmacy Management System Setup Guide

## Overview

This guide will help you set up the Dr. CRUD pharmacy management system using Laravel framework with the Sneat Bootstrap admin template integration.

## Prerequisites

-   PHP 8.1+ with required extensions
-   Composer (PHP dependency manager)
-   Node.js and npm (for asset compilation)
-   MySQL/MariaDB database
-   Web server (Apache/Nginx) or Laravel's built-in server
-   Git (for version control)

## Step 1: Laravel Project Setup

### Clone and Install Laravel Dependencies

```bash
# Clone the repository
git clone https://github.com/your-repo/dr-crud-laravel.git
cd dr-crud-laravel

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Laravel Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate Laravel application key
php artisan key:generate
```

### Configure .env file

Edit `.env` file with your database credentials:

```env
APP_NAME="Dr. CRUD Pharmacy"
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dr_crud_pharmacy
DB_USERNAME=your_username
DB_PASSWORD=your_password

SESSION_DRIVER=database
QUEUE_CONNECTION=sync
```

## Step 2: Database Setup with Laravel

### Create Database

```sql
CREATE DATABASE dr_crud_pharmacy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Run Laravel Migrations

```bash
# Run database migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Or run migrations with seeding in one command
php artisan migrate:fresh --seed
```

## Step 3: Laravel Authentication Setup

### Install Laravel Breeze (Optional - for enhanced auth)

```bash
# Install Laravel Breeze for authentication scaffolding
composer require laravel/breeze --dev
php artisan breeze:install

# Compile assets
npm run dev
```

### Or Use Built-in Laravel Auth

The project uses Laravel's built-in authentication with custom role management:

-   User model with role-based access control
-   Custom middleware for role protection
-   Session-based authentication

## Step 4: Asset Compilation with Vite

### Development Asset Compilation

```bash
# Install Node dependencies
npm install

# Run development server with hot reload
npm run dev

# Or build assets for development
npm run build
```

### Production Asset Compilation

```bash
# Build assets for production
npm run build
```

## Step 5: Laravel Artisan Commands

### Create Laravel Resources (if extending)

```bash
# Create model with migration, factory, and resource controller
php artisan make:model ModelName -mcr

# Create individual components
php artisan make:controller ControllerName --resource
php artisan make:request StoreRequestName
php artisan make:middleware MiddlewareName
php artisan make:seeder SeederName
```

### Database Operations

```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=SeederName
```

## Step 6: Laravel Development Server

### Start Laravel Development Server

```bash
# Start server on default port (8000)
php artisan serve

# Start server on specific host and port
php artisan serve --host=0.0.0.0 --port=8080
```

### Access the Application

-   **URL:** http://localhost:8000
-   **Admin Login:** admin / password123
-   **Pharmacist Login:** apoteker1 / password123
-   **Customer Registration:** Available via registration form

## Step 7: Laravel Configuration

### Configure Laravel Services

#### config/app.php

```php
<?php
return [
    'name' => env('APP_NAME', 'Dr. CRUD Pharmacy'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Jakarta',
    'locale' => 'en',
    'fallback_locale' => 'en',
    // ... other configurations
];
```

#### config/database.php

```php
<?php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'dr_crud_pharmacy'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict' => true,
            'engine' => null,
        ],
    ],
];
```

## Step 8: Laravel Blade Templates with Sneat Integration

### Main Layout Structure

```
resources/views/
├── layouts/
│   ├── app.blade.php          # Main application layout
│   ├── auth.blade.php         # Authentication layout
│   └── guest.blade.php        # Guest layout
├── components/
│   ├── navbar.blade.php       # Navigation bar component
│   ├── sidebar.blade.php      # Sidebar component
│   └── footer.blade.php       # Footer component
├── auth/
│   ├── login.blade.php        # Login page
│   └── register.blade.php     # Registration page
├── admin/
│   ├── dashboard.blade.php    # Admin dashboard
│   └── users/                 # User management views
├── pharmacist/
│   ├── dashboard.blade.php    # Pharmacist dashboard
│   └── sales/                 # Sales management views
└── customer/
    ├── dashboard.blade.php    # Customer dashboard
    └── catalog/               # Drug catalog views
```

### Sample Blade Layout (resources/views/layouts/app.blade.php)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dr. CRUD') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Sneat Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Layout page -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('components.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>

                    <!-- Footer -->
                    @include('components.footer')
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
```

## Step 9: Laravel Routes Configuration

### Web Routes (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AdminController,
    PharmacistController,
    CustomerController,
    DrugController,
    SaleController
};

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('drugs', DrugController::class);
    Route::resource('users', UserController::class);
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

// Pharmacist routes
Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
    Route::resource('sales', SaleController::class);
    Route::get('/drugs', [DrugController::class, 'index'])->name('drugs.index');
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');
    Route::get('/history', [CustomerController::class, 'history'])->name('history');
});

// API routes for AJAX
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/drugs/search', [DrugController::class, 'search'])->name('api.drugs.search');
    Route::get('/customers/search', [CustomerController::class, 'search'])->name('api.customers.search');
});
```

## Step 10: Laravel Testing

### Run Laravel Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run tests with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/DrugTest.php
```

### Create Tests

```bash
# Create feature test
php artisan make:test DrugTest

# Create unit test
php artisan make:test DrugUnitTest --unit
```

## Step 11: Laravel Optimization for Production

### Optimize Laravel Application

```bash
# Optimize configuration loading
php artisan config:cache

# Optimize route loading
php artisan route:cache

# Optimize view loading
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Clear all caches
php artisan optimize:clear
```

### Production Environment Setup

```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Use production session driver
SESSION_DRIVER=database

# Use production cache driver
CACHE_DRIVER=redis

# Use production queue driver
QUEUE_CONNECTION=redis
```

## Step 12: Laravel Maintenance Commands

### Common Laravel Maintenance

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear compiled services
php artisan clear-compiled

# List all routes
php artisan route:list

# Check Laravel version
php artisan --version
```

## Troubleshooting Laravel Issues

### Common Laravel Problems

#### 1. Permission Issues

```bash
# Fix storage permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Or more permissive (development only)
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

#### 2. Laravel Key Missing

```bash
php artisan key:generate
```

#### 3. Migration Issues

```bash
# Check migration status
php artisan migrate:status

# Rollback and re-run
php artisan migrate:refresh

# Fresh migrations with seeding
php artisan migrate:fresh --seed
```

#### 4. Composer Issues

```bash
# Update composer dependencies
composer update

# Regenerate autoloader
composer dump-autoload
```

## Laravel Resources and Documentation

### Official Laravel Resources

-   **Laravel Documentation**: https://laravel.com/docs
-   **Laravel API Documentation**: https://laravel.com/api/master
-   **Laracasts**: https://laracasts.com (Laravel video tutorials)
-   **Laravel News**: https://laravel-news.com

### Useful Laravel Packages

```bash
# Laravel Debugbar (development)
composer require barryvdh/laravel-debugbar --dev

# Laravel IDE Helper (development)
composer require barryvdh/laravel-ide-helper --dev

# Laravel Telescope (debugging)
composer require laravel/telescope --dev
```

## Project Structure Overview

```
dr-crud-laravel/
├── app/
│   ├── Http/Controllers/      # Laravel controllers
│   ├── Models/               # Eloquent models
│   ├── Http/Middleware/      # Custom middleware
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/              # Blade templates
│   ├── js/                 # JavaScript files
│   └── css/               # CSS files
├── routes/
│   ├── web.php            # Web routes
│   └── api.php            # API routes
├── public/
│   ├── assets/            # Sneat template assets
│   └── build/             # Vite compiled assets
├── config/                # Laravel configuration files
├── storage/               # Laravel storage (logs, cache, etc.)
└── tests/                # Laravel tests
```

---

**Note**: This setup guide provides a complete Laravel-based foundation for the Dr. CRUD pharmacy management system. The system leverages Laravel's powerful features including Eloquent ORM, Blade templating, middleware, and built-in authentication while integrating with the Sneat Bootstrap admin template for a professional UI.
