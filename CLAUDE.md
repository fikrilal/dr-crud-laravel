# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Dr. CRUD** is a pharmacy management system MVP built with Laravel framework and the Sneat Bootstrap admin template. The system supports three user roles (Admin, Pharmacist, Customer) with role-based access control for managing drugs, sales, inventory, and customer relationships.

**Key Architecture Decision**: This is built WITH Laravel framework as it's mandatory for this project. Laravel provides the MVC structure, Eloquent ORM, routing, and authentication systems.

## Development Commands

### Laravel Setup

```bash
# Install Laravel dependencies
composer install

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Clear all caches
php artisan optimize:clear
```

### Development Server

```bash
# Start Laravel development server
php artisan serve

# Alternative: Use Vite for asset compilation
npm run dev

# Build assets for production
npm run build
```

### Database Management

```bash
# Create new migration
php artisan make:migration create_table_name

# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Run fresh migrations with seeding
php artisan migrate:fresh --seed
```

### Testing

```bash
# Run Laravel tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Clear and rebuild caches
php artisan optimize
```

## Architecture Overview

### Laravel MVC Architecture

This project uses **Laravel framework** with proper MVC architecture:

-   **Database Layer**: Laravel Eloquent ORM with MySQL
-   **Authentication**: Laravel's built-in authentication with role management
-   **Templates**: Laravel Blade templates with Sneat Bootstrap integration
-   **Routing**: Laravel routing system with proper controllers
-   **Frontend**: Bootstrap 5 + Sneat template for rapid UI development

### Key Directories

```
├── docs/                    # Complete project documentation
│   ├── MVP_ARCHITECTURE.md  # System architecture and patterns
│   ├── MVP_FEATURES.md      # Features by user role
│   ├── DATABASE_SCHEMA.md   # Complete database design
│   └── PROJECT_ROADMAP.md   # 7-day development plan
├── app/                     # Laravel application files
│   ├── Http/Controllers/    # Laravel controllers with business logic
│   ├── Models/             # Eloquent models (one per database table)
│   ├── Http/Middleware/    # Custom middleware for role-based access
│   └── Providers/          # Service providers
├── resources/              # Laravel resources
│   ├── views/              # Blade templates using Sneat
│   ├── js/                 # JavaScript files (compiled by Vite)
│   └── css/                # CSS files (compiled by Vite)
├── routes/                 # Laravel routing files
│   ├── web.php            # Web routes
│   └── api.php            # API routes for AJAX
├── database/              # Laravel database files
│   ├── migrations/        # Database migration files
│   ├── seeders/           # Database seeder files
│   └── factories/         # Model factories for testing
├── public/                # Public web assets
│   ├── assets/           # Sneat template CSS/JS
│   └── build/            # Vite compiled assets
└── config/               # Laravel configuration files
```

### Database Integration Strategy

**Database Name**: `dr_crud_pharmacy` (Laravel naming convention)

**Core Tables** (9 total):

-   `users` - Laravel users table with role management
-   `sessions` - Laravel session handling
-   `drugs` - Drug inventory (Eloquent model)
-   `suppliers` - Supplier management
-   `customers` - Customer database
-   `sales` + `sale_details` - Sales transactions
-   `purchases` + `purchase_details` - Purchase orders

**Key Enhancement**: All tables use Laravel migrations with Eloquent relationships, timestamps, and proper foreign key constraints.

### Authentication & Session Management

**Three User Roles**:

-   `admin` - Full system control, user management, reporting
-   `pharmacist` - Sales processing, inventory management
-   `customer` - Drug browsing, purchase history

**Laravel Auth Flow**:

1. Laravel authentication with email/username
2. Role-based middleware for route protection
3. Laravel session management with database driver
4. Automatic redirect based on user roles

### Frontend Integration

**Bootstrap + Sneat Template Integration**:

-   Bootstrap 5 framework for rapid UI development
-   Sneat Bootstrap admin template for professional design
-   Blade layouts with pre-built Bootstrap components
-   Vite asset compilation for CSS/JS optimization
-   Blade components wrapping Bootstrap elements for reusability
-   Laravel Mix/Vite for asset management and hot reload

**AJAX Strategy**:

-   Laravel API routes for real-time features
-   CSRF token protection on all requests
-   JSON responses from Laravel controllers
-   Vue.js or Alpine.js for dynamic components

## Development Workflow

### Laravel Feature Development Pattern

1. **Migration First**: Create Laravel migration for database changes
2. **Model Creation**: Create Eloquent model with relationships
3. **Controller Logic**: Implement Laravel resource controllers
4. **Blade Templates**: Create Blade views with Sneat components
5. **Routes**: Define Laravel routes with middleware protection
6. **Testing**: Write Laravel feature tests

### Laravel Code Organization Principles

-   **Resource Controllers**: Use Laravel resource controllers for CRUD operations
-   **Eloquent Models**: Rich model relationships and scopes
-   **Blade Components**: Reusable UI components
-   **Form Requests**: Laravel validation with form request classes
-   **Middleware**: Role-based access control

### Database Query Strategy

-   **Eloquent ORM**: Use Eloquent for all database operations
-   **Query Builder**: Laravel query builder for complex queries
-   **Database Transactions**: Laravel transaction management
-   **Eager Loading**: Optimize queries with Eloquent relationships

## Important Configuration

### Laravel Environment

Located in `.env` file - Laravel environment configuration

```env
APP_NAME="Dr. CRUD Pharmacy"
DB_CONNECTION=mysql
DB_DATABASE=dr_crud_pharmacy
SESSION_DRIVER=database
```

### Laravel Authentication

-   Laravel Sanctum for API authentication
-   Custom middleware for role-based access
-   Laravel password reset functionality

### Asset Management

All assets managed by Laravel Vite:

-   CSS: Bootstrap + Sneat extensions (compiled by Vite)
-   JS: jQuery, Bootstrap, Laravel Echo (compiled by Vite)
-   Images: Stored in public/assets/

## Development Priorities

### Laravel + Bootstrap Rapid Development Approach

This MVP leverages Laravel and Bootstrap for maximum development speed:

-   **Laravel Artisan** for code generation and scaffolding
-   **Bootstrap 5** for rapid UI development without custom CSS
-   **Sneat Template** for professional admin interface components
-   **Eloquent ORM** for database relationships and queries
-   **Blade templating** for component-based UI with Bootstrap integration
-   **Laravel validation** for form handling and security

### Security Essentials (Laravel Built-in)

-   **CSRF protection** on all forms automatically
-   **SQL injection prevention** via Eloquent ORM
-   **XSS protection** through Blade template escaping
-   **Role-based access** via Laravel middleware
-   **Session security** with Laravel session management

### Performance Considerations

-   **Eloquent optimization** with eager loading and query scopes
-   **Laravel caching** for frequently accessed data
-   **Route caching** for production performance
-   **Database indexing** in Laravel migrations

## Common Development Tasks

### Adding New User Role Features

1. Update role middleware in `app/Http/Middleware/`
2. Create role-specific routes with middleware protection
3. Add role-based Blade views and components
4. Write Laravel feature tests for permissions

### Creating New CRUD Operations

1. Generate Laravel migration: `php artisan make:migration`
2. Create Eloquent model: `php artisan make:model ModelName -mcr`
3. Build resource controller with proper validation
4. Create Blade views using Sneat components
5. Define routes with appropriate middleware

### Database Schema Changes

1. Create Laravel migration: `php artisan make:migration`
2. Define schema changes using Laravel schema builder
3. Update Eloquent model relationships
4. Run migration: `php artisan migrate`

### Integrating New Bootstrap/Sneat Components

1. Find Bootstrap component in Sneat template documentation
2. Create Blade component: `php artisan make:component ComponentName`
3. Copy Bootstrap/Sneat HTML structure to Blade component
4. Add Laravel Blade syntax for dynamic data
5. Ensure Bootstrap CSS/JS dependencies are loaded
6. Include component in views with `<x-component-name />`
7. Test responsive behavior across device sizes

## Documentation References

Critical documentation files (read these first):

-   `docs/MVP_ARCHITECTURE.md` - Laravel system design and patterns
-   `docs/MVP_FEATURES.md` - Complete feature specifications using Laravel
-   `docs/DATABASE_SCHEMA.md` - Database design with Laravel migrations
-   `docs/PROJECT_ROADMAP.md` - 7-day Laravel development timeline

## Laravel Artisan Commands Reference

### Model and Controller Generation

```bash
# Create model with migration, factory, and resource controller
php artisan make:model Drug -mcr

# Create resource controller
php artisan make:controller DrugController --resource

# Create form request for validation
php artisan make:request StoreDrugRequest

# Create custom middleware
php artisan make:middleware RoleMiddleware
```

### Database Operations

```bash
# Create migration
php artisan make:migration create_drugs_table

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migrate with seeding
php artisan migrate:fresh --seed

# Create seeder
php artisan make:seeder DrugSeeder
```

### Views and Components

```bash
# Create Blade component
php artisan make:component DrugCard

# Publish Laravel UI scaffolding
php artisan ui bootstrap --auth

# Clear view cache
php artisan view:clear
```

### Testing Commands

```bash
# Create feature test
php artisan make:test DrugTest

# Create unit test
php artisan make:test DrugUnitTest --unit

# Run tests
php artisan test

# Run specific test file
php artisan test --filter DrugTest
```

### Optimization Commands

```bash
# Cache routes for production
php artisan route:cache

# Cache configuration
php artisan config:cache

# Cache views
php artisan view:cache

# Clear all caches
php artisan optimize:clear
```

## Technology Stack Notes

### Why Laravel Framework

-   **Rapid Development**: Artisan commands for scaffolding
-   **Rich Ecosystem**: Extensive package ecosystem
-   **Security**: Built-in CSRF, authentication, and validation
-   **Database**: Eloquent ORM with powerful relationships
-   **Testing**: Built-in testing framework with PHPUnit

### Frontend Technology Choices (Bootstrap-First)

-   **Bootstrap 5**: Primary CSS framework for rapid UI development
-   **Sneat Admin Template**: Professional Bootstrap-based admin interface
-   **Laravel Vite**: Modern asset compilation and hot reload
-   **jQuery**: For Bootstrap component interactions and AJAX
-   **Alpine.js/Vue.js**: For reactive components (when Bootstrap isn't sufficient)
-   **Laravel Echo**: For real-time features (if needed)

### Database Technology

-   **MySQL/MariaDB**: Standard Laravel database choice
-   **Laravel Migrations**: Version-controlled schema changes
-   **Eloquent ORM**: Rich model relationships and query builder

## Bootstrap + Laravel Development Strategy

### Bootstrap-First UI Development

-   **Use Bootstrap Components**: Leverage Bootstrap 5 components instead of custom CSS
-   **Sneat Template**: Utilize pre-built Sneat admin components for consistency
-   **Responsive Design**: Use Bootstrap's grid system and utilities for mobile-first design
-   **Form Components**: Use Bootstrap form classes with Laravel Blade for rapid form development
-   **Data Tables**: Implement Bootstrap tables with Laravel pagination
-   **Modal Forms**: Use Bootstrap modals for CRUD operations without page reloads
-   **Navigation**: Utilize Bootstrap navbar and sidebar components from Sneat

### Bootstrap Integration Examples

```blade
<!-- Bootstrap Card with Laravel Blade -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ $title }}</h5>
    </div>
    <div class="card-body">
        @foreach($items as $item)
            <p class="card-text">{{ $item->name }}</p>
        @endforeach
    </div>
</div>

<!-- Bootstrap Form with Laravel -->
<form method="POST" action="{{ route('drugs.store') }}" class="row g-3">
    @csrf
    <div class="col-md-6">
        <label class="form-label">Drug Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
               name="name" value="{{ old('name') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</form>
```

## Laravel Best Practices for This Project

### Code Organization

-   Use Laravel resource controllers for CRUD operations
-   Create Form Request classes for complex validation
-   Use Eloquent model relationships instead of manual joins
-   Implement Laravel middleware for role-based access control

### Security

-   Always use Laravel's CSRF protection
-   Validate input using Laravel Form Requests
-   Use Eloquent mass assignment protection
-   Implement proper authentication with Laravel Sanctum

### Performance

-   Use Eloquent eager loading to prevent N+1 queries
-   Implement Laravel caching for frequently accessed data
-   Use Laravel queue system for heavy operations
-   Optimize database queries with proper indexing

### Testing

-   Write Laravel feature tests for all major functionality
-   Use Laravel factories for test data generation
-   Test role-based access control with middleware
-   Use Laravel's testing database for isolated tests
