@extends('layouts.app')

@section('title', 'Blog Feed')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-12">
                <!-- Header Section -->
                <div class="bg-white shadow-sm mb-0">
                    <div class="container py-4">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-blog text-white fs-3"></i>
                                    </div>
                                    <div>
                                        <h1 class="display-6 fw-bold text-primary mb-0">Social Blog</h1>
                                        <p class="text-muted mb-0">Connect, Share, Inspire</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="py-5">
                    <livewire:blog-feed />
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.min-vh-100 {
    min-height: 100vh;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Smooth animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

/* Responsive design */
@media (max-width: 768px) {
    .display-6 {
        font-size: 1.75rem;
    }
    
    .container-fluid[style*="max-width: 680px"] {
        max-width: 100% !important;
        padding: 0 15px;
    }
}

/* Loading states */
[wire\:loading] {
    opacity: 0.7;
}

/* Button hover effects */
.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
}

/* Pulse effect for load more button */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
    }
}

.btn-primary:not(:disabled):not(.disabled) {
    animation: pulse 2s infinite;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize infinite scroll functionality
    function initInfiniteScroll() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Find the Livewire component and trigger loadMore
                    const blogFeedComponent = window.Livewire.find('blog-feed');
                    if (blogFeedComponent && blogFeedComponent.hasMorePages) {
                        blogFeedComponent.call('loadMore');
                    }
                }
            });
        }, {
            rootMargin: '100px'
        });

        const trigger = document.getElementById('infinite-scroll-trigger');
        if (trigger) {
            observer.observe(trigger);
        }
    }

    // Initialize after Livewire is ready
    if (window.Livewire) {
        initInfiniteScroll();
        
        // Re-initialize when component updates
        Livewire.on('contentChanged', () => {
            setTimeout(initInfiniteScroll, 100);
        });
    } else {
        // Wait for Livewire to load
        document.addEventListener('livewire:init', initInfiniteScroll);
    }
});
</script>
@endsection