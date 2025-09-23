<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
        
        .navbar {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-brand, .nav-link {
            color: white !important;
        }
        
        .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .main-content {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 500;
            border-radius: 10px;
            padding: 12px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .btn-success-gradient {
            background: var(--success-gradient);
            border: none;
            color: white;
            font-weight: 500;
            border-radius: 10px;
            padding: 12px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-success-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .btn-secondary-gradient {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            font-weight: 500;
            border-radius: 10px;
            padding: 12px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            padding: 12px 16px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            color: white;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .form-label {
            color: white;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .alert {
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(20px);
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        
        .alert-success-custom {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.15) 100%);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #fff;
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.2);
        }
        
        .alert-success-custom .alert-icon {
            color: #22c55e;
        }
        
        .alert-success-custom .alert-heading {
            color: #fff;
            font-weight: 600;
        }
        
        .alert-info-custom {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #fff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
        }
        
        .alert-info-custom .alert-icon {
            color: #3b82f6;
        }
        
        .alert-info-custom small {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }
        
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 15px !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
        }
        
        .dropdown-item {
            color: white !important;
            background: transparent !important;
            border: none !important;
        }
        
        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }
        
        .dropdown-item:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
        }
        
        .dropdown-item:active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        
        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        /* Additional Alert Improvements */
        .alert-success-custom p {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .alert-success-custom .alert-heading {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>
    
    @livewireStyles
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-user-circle me-2"></i>{{ config('app.name', 'Laravel') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user-profile') }}">
                                    <i class="fas fa-user-edit me-2"></i>Profile
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-home me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fas fa-users me-2"></i>Users
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        {{ $slot }}
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
