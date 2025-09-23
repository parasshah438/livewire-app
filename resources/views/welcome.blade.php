<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Livewire Demo</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.12);
        }
        
        .btn-gradient-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 15px 30px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .btn-gradient-secondary {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            font-weight: 500;
            border-radius: 50px;
            padding: 12px 25px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-gradient-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            color: white;
        }
        
        .btn-outline-light-custom {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            background: transparent;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-outline-light-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
        }
        
        .navbar-custom {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .text-shadow {
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .icon-gradient {
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand text-white fw-bold fs-4" href="{{ url('/') }}">
                <i class="fas fa-bolt me-2"></i>{{ config('app.name', 'Laravel') }}
            </a>
            
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('products') }}" class="btn-outline-light-custom">
                    <i class="fas fa-shopping-bag me-2"></i>Products
                </a>
                
                @livewire('cart-count')
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-outline-light-custom">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-outline-light-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-gradient-secondary">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-fluid" style="padding-top: 100px;">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <div class="hero-card p-5 mb-5 floating">
                        <h1 class="display-4 fw-bold text-white text-shadow mb-4">
                            Welcome to <span class="icon-gradient">Livewire</span> Demo
                        </h1>
                        <p class="lead text-white-50 mb-4">
                            Experience the power of Laravel Livewire 3 with real-time components, 
                            file uploads, and interactive user interfaces without leaving PHP!
                        </p>
                        
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <a href="{{ route('products') }}" class="btn-gradient-primary pulse-animation">
                                <i class="fas fa-shopping-bag me-2"></i>Shop Now
                            </a>
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-gradient-secondary">
                                    <i class="fas fa-rocket me-2"></i>Go to Dashboard
                                </a>
                                <a href="{{ route('user-profile') }}" class="btn-outline-light-custom">
                                    <i class="fas fa-user me-2"></i>My Profile
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-gradient-secondary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Get Started
                                </a>
                                <a href="{{ route('register') }}" class="btn-outline-light-custom">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="mb-3">
                                    <i class="fas fa-bolt fs-1 icon-gradient"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-3">Real-time Components</h5>
                                <p class="text-white-50 small">
                                    Interactive PHP components that update in real-time without page refreshes.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="mb-3">
                                    <i class="fas fa-upload fs-1 icon-gradient"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-3">File Uploads</h5>
                                <p class="text-white-50 small">
                                    Seamless file upload system with progress indicators and validation.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="mb-3">
                                    <i class="fas fa-search fs-1 icon-gradient"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-3">Advanced Search</h5>
                                <p class="text-white-50 small">
                                    Powerful search and filtering capabilities with instant results.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="mb-3">
                                    <i class="fas fa-shopping-cart fs-1 icon-gradient"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-3">Shopping Cart</h5>
                                <p class="text-white-50 small">
                                    Complete eCommerce cart system with real-time updates and persistence.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container my-5 py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold text-white text-shadow mb-3">
                    What's Inside This Demo
                </h2>
                <p class="lead text-white-50">
                    Explore the complete features built with Laravel Livewire 3
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background: var(--primary-gradient);">
                            <i class="fas fa-shield-alt text-white"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Authentication System</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Complete registration, login, and password reset functionality with form validation.
                    </p>
                    <ul class="list-unstyled text-white-50 small">
                        <li><i class="fas fa-check text-success me-2"></i>User Registration</li>
                        <li><i class="fas fa-check text-success me-2"></i>Secure Login</li>
                        <li><i class="fas fa-check text-success me-2"></i>Password Reset</li>
                        <li><i class="fas fa-check text-success me-2"></i>Form Validation</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background: var(--secondary-gradient);">
                            <i class="fas fa-user-cog text-white"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Profile Management</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Advanced user profile system with photo uploads and password management.
                    </p>
                    <ul class="list-unstyled text-white-50 small">
                        <li><i class="fas fa-check text-success me-2"></i>Profile Photo Upload</li>
                        <li><i class="fas fa-check text-success me-2"></i>Password Change</li>
                        <li><i class="fas fa-check text-success me-2"></i>Profile Information</li>
                        <li><i class="fas fa-check text-success me-2"></i>File Validation</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background: var(--success-gradient);">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">User Management</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Comprehensive user listing with CRUD operations and advanced features.
                    </p>
                    <ul class="list-unstyled text-white-50 small">
                        <li><i class="fas fa-check text-success me-2"></i>User Listing & Pagination</li>
                        <li><i class="fas fa-check text-success me-2"></i>Advanced Search & Filter</li>
                        <li><i class="fas fa-check text-success me-2"></i>Bulk Operations</li>
                        <li><i class="fas fa-check text-success me-2"></i>CSV Export</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background: var(--primary-gradient);">
                            <i class="fas fa-tachometer-alt text-white"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Real-time Updates</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Live components that update without page refreshes using Livewire events.
                    </p>
                    <ul class="list-unstyled text-white-50 small">
                        <li><i class="fas fa-check text-success me-2"></i>Toast Notifications</li>
                        <li><i class="fas fa-check text-success me-2"></i>Live Search Results</li>
                        <li><i class="fas fa-check text-success me-2"></i>Dynamic Content</li>
                        <li><i class="fas fa-check text-success me-2"></i>Event Broadcasting</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background: var(--secondary-gradient);">
                            <i class="fas fa-paint-brush text-white"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Modern UI/UX</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Beautiful Bootstrap 5 design with glassmorphism effects and animations.
                    </p>
                    <ul class="list-unstyled text-white-50 small">
                        <li><i class="fas fa-check text-success me-2"></i>Glassmorphism Design</li>
                        <li><i class="fas fa-check text-success me-2"></i>Responsive Layout</li>
                        <li><i class="fas fa-check text-success me-2"></i>Smooth Animations</li>
                        <li><i class="fas fa-check text-success me-2"></i>Dark Mode Support</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background: var(--success-gradient);">
                            <i class="fas fa-download text-white"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Data Export</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Export functionality with streaming downloads and customizable formats.
                    </p>
                    <ul class="list-unstyled text-white-50 small">
                        <li><i class="fas fa-check text-success me-2"></i>CSV Export</li>
                        <li><i class="fas fa-check text-success me-2"></i>Selective Export</li>
                        <li><i class="fas fa-check text-success me-2"></i>Streaming Downloads</li>
                        <li><i class="fas fa-check text-success me-2"></i>Large Dataset Support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="hero-card p-5 text-center">
                    <h3 class="display-6 fw-bold text-white text-shadow mb-4">
                        Ready to Explore Livewire?
                    </h3>
                    <p class="lead text-white-50 mb-4">
                        Experience the future of PHP development with Laravel Livewire 3. 
                        Build reactive components without writing JavaScript!
                    </p>
                    
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-gradient-primary">
                                <i class="fas fa-rocket me-2"></i>Explore Dashboard
                            </a>
                            <a href="{{ route('users.index') }}" class="btn-gradient-secondary">
                                <i class="fas fa-users me-2"></i>User Management
                            </a>
                        @else
                            <a href="{{ route('products') }}" class="btn-gradient-primary pulse-animation">
                                <i class="fas fa-shopping-bag me-2"></i>Browse Products
                            </a>
                            <a href="{{ route('register') }}" class="btn-gradient-secondary">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </a>
                            <a href="{{ route('login') }}" class="btn-outline-light-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Demo
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="container-fluid py-4 mt-5" style="background: rgba(0, 0, 0, 0.2);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-code me-2"></i>
                        Built with Laravel {{ app()->version() }} & Livewire 3
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-server me-2"></i>
                        PHP {{ PHP_VERSION }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
