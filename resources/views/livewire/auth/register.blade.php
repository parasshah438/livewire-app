<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-user-plus fa-2x mb-3"></i>
        <h1>Create Account</h1>
        <p>Join us today and get started</p>
    </div>
    
    <div class="auth-body">
        <div class="auth-form">
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('message') }}
                </div>
            @endif

            <div class="form-container">
                <form wire:submit.prevent="register">
                    <div class="form-floating">
                        <input 
                            wire:model.blur="name" 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            placeholder="Full Name"
                            autocomplete="name"
                            wire:loading.attr="disabled"
                            wire:target="register"
                        >
                        <label for="name">
                            <i class="fas fa-user me-2"></i>Full Name
                        </label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input 
                            wire:model.blur="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            placeholder="name@example.com"
                            autocomplete="email"
                            wire:loading.attr="disabled"
                            wire:target="register"
                        >
                        <label for="email">
                            <i class="fas fa-envelope me-2"></i>Email Address
                        </label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input 
                            wire:model.blur="password" 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            placeholder="Password"
                            autocomplete="new-password"
                            wire:loading.attr="disabled"
                            wire:target="register"
                        >
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input 
                            wire:model.blur="password_confirmation" 
                            type="password" 
                            class="form-control" 
                            id="password_confirmation" 
                            placeholder="Confirm Password"
                            autocomplete="new-password"
                            wire:loading.attr="disabled"
                            wire:target="register"
                        >
                        <label for="password_confirmation">
                            <i class="fas fa-lock me-2"></i>Confirm Password
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth btn-loading" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="register">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </span>
                        <span wire:loading wire:target="register">
                            <div class="spinner-custom"></div>
                            <span class="loading-text">Creating Account...</span>
                        </span>
                    </button>
                </form>

                <!-- Loading overlay that doesn't affect layout -->
                <div wire:loading wire:target="register" class="loading-overlay">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0 text-muted">Creating your account...</p>
                    </div>
                </div>
            </div>

            <div class="auth-links">
                <p class="mb-0">
                    Already have an account? 
                    <a href="{{ route('login') }}" wire:navigate>
                        <i class="fas fa-sign-in-alt me-1"></i>Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
