<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-sign-in-alt fa-2x mb-3"></i>
        <h1>Welcome Back</h1>
        <p>Sign in to your account</p>
    </div>
    
    <div class="auth-body">
        <div class="auth-form">
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('status'))
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <div class="form-container">
                <form wire:submit.prevent="login">
                    <div class="form-floating">
                        <input 
                            wire:model.blur="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            placeholder="name@example.com"
                            autocomplete="email"
                            wire:loading.attr="disabled"
                            wire:target="login"
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
                            autocomplete="current-password"
                            wire:loading.attr="disabled"
                            wire:target="login"
                        >
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input 
                            wire:model="remember" 
                            class="form-check-input" 
                            type="checkbox" 
                            id="remember"
                            wire:loading.attr="disabled"
                            wire:target="login"
                        >
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth btn-loading" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="login">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </span>
                        <span wire:loading wire:target="login">
                            <div class="spinner-custom"></div>
                            <span class="loading-text">Signing In...</span>
                        </span>
                    </button>
                </form>

                <!-- Loading overlay that doesn't affect layout -->
                <div wire:loading wire:target="login" class="loading-overlay">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0 text-muted">Authenticating...</p>
                    </div>
                </div>
            </div>

            <div class="auth-links">
                <p class="mb-2">
                    <a href="{{ route('password.request') }}" wire:navigate>
                        <i class="fas fa-key me-1"></i>Forgot your password?
                    </a>
                </p>
                <p class="mb-0">
                    Don't have an account? 
                    <a href="{{ route('register') }}" wire:navigate>
                        <i class="fas fa-user-plus me-1"></i>Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
