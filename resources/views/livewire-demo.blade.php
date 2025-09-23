<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire 3 Learning Demo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles for Lifecycle Demo -->
    <style>
        .bg-light-success { background-color: rgba(25, 135, 84, 0.1) !important; }
        .bg-light-warning { background-color: rgba(255, 193, 7, 0.1) !important; }
        .bg-light-info { background-color: rgba(13, 202, 240, 0.1) !important; }
        .bg-light-secondary { background-color: rgba(108, 117, 125, 0.1) !important; }
        .bg-light-primary { background-color: rgba(13, 110, 253, 0.1) !important; }
    </style>
    @livewireStyles
</head>
<body class="bg-light min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-bolt me-2"></i>🚀 Livewire 3 Learning
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('counter') }}" class="nav-link {{ $component === 'counter' ? 'active' : '' }}">
                    <i class="fas fa-calculator me-1"></i>Counter
                </a>
                <a href="{{ route('lifecycle') }}" class="nav-link {{ $component === 'lifecycle' ? 'active' : '' }}">
                    <i class="fas fa-cogs me-1"></i>Lifecycle
                </a>
                <a href="{{ route('user-profile') }}" class="nav-link">
                    <i class="fas fa-user me-1"></i>User Profile
                </a>
            
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        {{-- Render the specified component --}}
        @if($component === 'counter')
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <livewire:counter />
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
