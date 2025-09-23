<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-key fa-2x mb-3"></i>
        <h1>Reset Password</h1>
        <p>We'll send you a reset link</p>
    </div>
    
    <div class="auth-body">
        <div class="auth-form">
            @if (session()->has('status'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if (!$emailSent)
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Enter your email address and we'll send you a link to reset your password.
                </div>

                <div class="form-container">
                    <form wire:submit.prevent="sendResetLink">
                        <div class="form-floating">
                            <input 
                                wire:model.blur="email" 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                placeholder="name@example.com"
                                autocomplete="email"
                                wire:loading.attr="disabled"
                                wire:target="sendResetLink"
                            >
                            <label for="email">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-auth btn-loading" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="sendResetLink">
                                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                            </span>
                            <span wire:loading wire:target="sendResetLink">
                                <div class="spinner-custom"></div>
                                <span class="loading-text">Sending...</span>
                            </span>
                        </button>
                    </form>

                    <!-- Loading overlay that doesn't affect layout -->
                    <div wire:loading wire:target="sendResetLink" class="loading-overlay">
                        <div class="text-center">
                            <div class="spinner-border text-primary mb-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mb-0 text-muted">Sending reset link...</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-success text-center" role="alert">
                    <i class="fas fa-check-circle fa-3x mb-3 d-block"></i>
                    <h5>Email Sent Successfully!</h5>
                    <p class="mb-0">Check your email for the password reset link.</p>
                </div>
            @endif

            <div class="auth-links">
                <p class="mb-2">
                    <a href="{{ route('login') }}" wire:navigate>
                        <i class="fas fa-arrow-left me-1"></i>Back to Login
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
