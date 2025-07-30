<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dr. CRUD - Pharmacy Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #28a745;
            --accent-color: #17a2b8;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar.scrolled {
            background: rgba(44, 90, 160, 0.95);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,0 1000,100 0,100"/></svg>') no-repeat center bottom;
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            transition: transform 0.3s ease;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        
        .stats-section {
            background: var(--bg-light);
            padding: 4rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }
        
        .stat-label {
            color: var(--text-light);
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }
        
        .demo-section {
            padding: 5rem 0;
        }
        
        .role-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary-color);
            height: 100%;
        }
        
        .role-card.admin {
            border-left-color: #dc3545;
        }
        
        .role-card.pharmacist {
            border-left-color: var(--secondary-color);
        }
        
        .role-card.customer {
            border-left-color: var(--accent-color);
        }
        
        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 35px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(44, 90, 160, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(44, 90, 160, 0.4);
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 5rem 0;
        }
        
        .footer {
            background: #1a252f;
            color: white;
            padding: 3rem 0 1.5rem;
        }
        
        .footer-link {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0 60px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body class="smooth-scroll">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#home">
                <i class="bi bi-heart-pulse me-2"></i>Dr. CRUD
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#demo">Demo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <span class="badge bg-light text-primary mb-3 px-3 py-2">
                            <i class="bi bi-star-fill me-1"></i>Professional Pharmacy Solution
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-4">
                        Complete Pharmacy Management System
                    </h1>
                    <p class="lead mb-4">
                        Dr. CRUD streamlines your pharmacy operations with comprehensive drug inventory management, 
                        sales processing, customer relationships, and supplier coordination - all in one powerful platform.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#demo" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-play-circle me-2"></i>Try Demo
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-info-circle me-2"></i>Learn More
                        </a>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-check fs-3 me-2"></i>
                                <div>
                                    <div class="fw-bold">Secure</div>
                                    <small class="opacity-75">Role-based Access</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-lightning fs-3 me-2"></i>
                                <div>
                                    <div class="fw-bold">Fast</div>
                                    <small class="opacity-75">Quick Processing</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-graph-up fs-3 me-2"></i>
                                <div>
                                    <div class="fw-bold">Smart</div>
                                    <small class="opacity-75">Analytics Ready</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300' fill='none'%3E%3Crect width='400' height='300' fill='%23ffffff' fill-opacity='0.1' rx='20'/%3E%3Ccircle cx='200' cy='150' r='60' fill='%23ffffff' fill-opacity='0.2'/%3E%3Cpath d='M200 110v80M160 150h80' stroke='%23ffffff' stroke-width='4' stroke-linecap='round'/%3E%3C/svg%3E" 
                             alt="Pharmacy System Illustration" class="img-fluid" style="max-width: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">3</div>
                        <div class="stat-label">User Roles</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">9</div>
                        <div class="stat-label">Core Tables</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Laravel Framework</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">System Availability</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Powerful Features</h2>
                <p class="lead text-muted">Everything you need to manage your pharmacy efficiently</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-capsule"></i>
                        </div>
                        <h4 class="text-center mb-3">Drug Management</h4>
                        <p class="text-muted text-center">
                            Complete drug catalog with inventory tracking, expiry management, 
                            and advanced search capabilities.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Real-time inventory</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Expiry date alerts</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Category management</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <h4 class="text-center mb-3">Sales Processing</h4>
                        <p class="text-muted text-center">
                            Streamlined sales transactions with automatic receipt generation 
                            and discount management.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Quick checkout</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Discount system</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Receipt printing</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="text-center mb-3">Customer Management</h4>
                        <p class="text-muted text-center">
                            Maintain customer database with purchase history 
                            and relationship management tools.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Customer database</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Purchase history</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Customer analytics</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h4 class="text-center mb-3">Supplier Management</h4>
                        <p class="text-muted text-center">
                            Coordinate with suppliers through purchase order management 
                            and supplier performance tracking.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Purchase orders</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Supplier database</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Performance tracking</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h4 class="text-center mb-3">Reports & Analytics</h4>
                        <p class="text-muted text-center">
                            Comprehensive reporting system with sales analytics, 
                            inventory reports, and business insights.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Sales reports</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Inventory analytics</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Business insights</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="text-center mb-3">Security & Access</h4>
                        <p class="text-muted text-center">
                            Role-based access control with secure authentication 
                            and permission management system.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Role-based access</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Secure authentication</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Audit trail</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="demo-section bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">User Roles & Access Levels</h2>
                <p class="lead text-muted">Experience the system from different user perspectives</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="role-card admin">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-gear display-4 text-danger"></i>
                            <h4 class="mt-3 mb-2">Admin User</h4>
                            <span class="badge bg-danger">Full Access</span>
                        </div>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check text-danger me-2"></i>User management</li>
                            <li><i class="bi bi-check text-danger me-2"></i>Master data control</li>
                            <li><i class="bi bi-check text-danger me-2"></i>Complete inventory access</li>
                            <li><i class="bi bi-check text-danger me-2"></i>Sales reporting & analytics</li>
                            <li><i class="bi bi-check text-danger me-2"></i>System administration</li>
                        </ul>
                        <div class="mt-4">
                            <div class="alert alert-danger border-0">
                                <strong>Demo Credentials:</strong><br>
                                Username: admin<br>
                                Password: admin123
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="role-card pharmacist">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-hearts display-4 text-success"></i>
                            <h4 class="mt-3 mb-2">Pharmacist</h4>
                            <span class="badge bg-success">Operations Access</span>
                        </div>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check text-success me-2"></i>Drug inventory management</li>
                            <li><i class="bi bi-check text-success me-2"></i>Sales transaction processing</li>
                            <li><i class="bi bi-check text-success me-2"></i>Basic reporting</li>
                            <li><i class="bi bi-check text-success me-2"></i>Customer service</li>
                            <li><i class="bi bi-check text-success me-2"></i>Expiry management</li>
                        </ul>
                        <div class="mt-4">
                            <div class="alert alert-success border-0">
                                <strong>Demo Credentials:</strong><br>
                                Username: pharmacist<br>
                                Password: pharmacist123
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="role-card customer">
                        <div class="text-center mb-4">
                            <i class="bi bi-person display-4 text-info"></i>
                            <h4 class="mt-3 mb-2">Customer</h4>
                            <span class="badge bg-info">Browse Access</span>
                        </div>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check text-info me-2"></i>Browse available drugs</li>
                            <li><i class="bi bi-check text-info me-2"></i>View drug details & pricing</li>
                            <li><i class="bi bi-check text-info me-2"></i>Account registration</li>
                            <li><i class="bi bi-check text-info me-2"></i>Search medications</li>
                            <li><i class="bi bi-check text-info me-2"></i>View purchase history</li>
                        </ul>
                        <div class="mt-4">
                            <div class="alert alert-info border-0">
                                <strong>Demo Credentials:</strong><br>
                                Username: customer<br>
                                Password: customer123
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('login') ?? '#' }}" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Try Demo Login
                </a>
            </div>
        </div>
    </section>

    <!-- Technology Stack -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Built with Modern Technology</h2>
                <p class="lead text-muted">Powered by Laravel framework and Bootstrap for reliability and performance</p>
            </div>
            
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="text-center p-4">
                                <i class="bi bi-code-square display-4 text-primary mb-3"></i>
                                <h5>Laravel Framework</h5>
                                <p class="text-muted small">Robust PHP framework for secure, scalable applications</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-4">
                                <i class="bi bi-bootstrap display-4 text-primary mb-3"></i>
                                <h5>Bootstrap 5</h5>
                                <p class="text-muted small">Modern CSS framework for responsive design</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-4">
                                <i class="bi bi-database display-4 text-primary mb-3"></i>
                                <h5>MySQL Database</h5>
                                <p class="text-muted small">Reliable database with Eloquent ORM</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-4">
                                <i class="bi bi-shield-lock display-4 text-primary mb-3"></i>
                                <h5>Security First</h5>
                                <p class="text-muted small">Built-in CSRF protection and authentication</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-4">
                        <h3 class="fw-bold mb-4">Why Choose Dr. CRUD?</h3>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="bi bi-lightning-charge text-warning fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Rapid Development</h6>
                                        <p class="text-muted small mb-0">Built with Laravel and Bootstrap for fast deployment and easy maintenance</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Enterprise Security</h6>
                                        <p class="text-muted small mb-0">Role-based access control with secure authentication and data protection</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="bi bi-arrows-angle-expand text-info fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Scalable Architecture</h6>
                                        <p class="text-muted small mb-0">MVC pattern with Laravel framework ensures maintainable and scalable code</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="bi bi-phone text-primary fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Mobile Responsive</h6>
                                        <p class="text-muted small mb-0">Bootstrap-powered responsive design works on all devices</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-3">Ready to Transform Your Pharmacy?</h2>
                    <p class="lead mb-0">
                        Start managing your pharmacy operations efficiently with Dr. CRUD. 
                        Try our demo or contact us for a personalized demonstration.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('login') ?? '#' }}" class="btn btn-light btn-lg me-3">
                        <i class="bi bi-play-circle me-2"></i>Try Demo
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-heart-pulse me-2"></i>Dr. CRUD
                    </h5>
                    <p class="text-muted">
                        Complete pharmacy management system built with Laravel framework and Bootstrap. 
                        Streamline your pharmacy operations with our comprehensive solution.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-link fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-link fs-5"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="footer-link fs-5"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="footer-link fs-5"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Features</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Drug Management</a></li>
                        <li><a href="#" class="footer-link">Sales Processing</a></li>
                        <li><a href="#" class="footer-link">Inventory Control</a></li>
                        <li><a href="#" class="footer-link">Reports</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">User Roles</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Admin Dashboard</a></li>
                        <li><a href="#" class="footer-link">Pharmacist Panel</a></li>
                        <li><a href="#" class="footer-link">Customer Portal</a></li>
                        <li><a href="#" class="footer-link">Demo Access</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Technology</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Laravel Framework</a></li>
                        <li><a href="#" class="footer-link">Bootstrap CSS</a></li>
                        <li><a href="#" class="footer-link">MySQL Database</a></li>
                        <li><a href="#" class="footer-link">Security</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Documentation</a></li>
                        <li><a href="#" class="footer-link">Help Center</a></li>
                        <li><a href="#" class="footer-link">Contact Us</a></li>
                        <li><a href="#" class="footer-link">System Status</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; {{ date('Y') }} Dr. CRUD Pharmacy Management System. Built with Laravel {{ Illuminate\Foundation\Application::VERSION }}.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="footer-link me-4">Privacy Policy</a>
                    <a href="#" class="footer-link me-4">Terms of Service</a>
                    <a href="#" class="footer-link">License</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animation on scroll for cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.feature-card, .role-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>
