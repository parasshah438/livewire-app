
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Welcome Card -->
            <div class="profile-card p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="text-white mb-2">
                            <i class="fas fa-home me-3"></i>Welcome back, {{ auth()->user()->name }}!
                        </h2>
                        <p class="text-white-75 mb-0">
                            You are successfully logged in to your dashboard.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-grid gap-2">
                            <a href="{{ route('user-profile') }}" class="btn btn-gradient" wire:navigate>
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('message'))
                <div class="alert alert-success-custom d-flex align-items-center mb-4" role="alert">
                    <div class="alert-icon me-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">Success!</h5>
                        <p class="mb-0">{{ session('message') }}</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="profile-card p-4 text-center h-100">
                        <div class="card-icon-wrapper mb-3">
                            <i class="fas fa-user-circle fa-4x text-white"></i>
                        </div>
                        <h5 class="text-white mb-2">Your Profile</h5>
                        <p class="text-white-75 small mb-3">
                            Member since {{ auth()->user()->created_at->format('M Y') }}
                        </p>
                        <a href="{{ route('user-profile') }}" class="btn btn-gradient btn-sm" wire:navigate>
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="profile-card p-4 text-center h-100">
                        <div class="card-icon-wrapper mb-3">
                            <i class="fas fa-code fa-4x text-white"></i>
                        </div>
                        <h5 class="text-white mb-2">Counter Demo</h5>
                        <p class="text-white-75 small mb-3">
                            Interactive Livewire component
                        </p>
                        <a href="{{ route('counter') }}" class="btn btn-secondary-gradient btn-sm" wire:navigate>
                            <i class="fas fa-play me-2"></i>Try Demo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="profile-card p-4">
                <h4 class="text-white mb-4">
                    <i class="fas fa-clock me-2"></i>Recent Activity
                </h4>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center mb-3 p-3" style="background: rgba(255, 255, 255, 0.05); border-radius: 15px;">
                            <div class="me-3">
                                <i class="fas fa-sign-in-alt fa-2x text-white"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Logged In</h6>
                                <p class="text-white-75 small mb-0">
                                    Successfully logged into your account
                                </p>
                            </div>
                            <div class="ms-auto">
                                <span class="badge bg-success">Today</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3 p-3" style="background: rgba(255, 255, 255, 0.05); border-radius: 15px;">
                            <div class="me-3">
                                <i class="fas fa-user-plus fa-2x text-white"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Account Created</h6>
                                <p class="text-white-75 small mb-0">
                                    Welcome to the platform!
                                </p>
                            </div>
                            <div class="ms-auto">
                                <span class="badge bg-primary">{{ auth()->user()->created_at->format('M d') }}</span>
                            </div>
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
