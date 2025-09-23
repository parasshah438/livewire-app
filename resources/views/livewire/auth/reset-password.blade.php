<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-lock fa-2x mb-3"></i>
        <h1>Reset Password</h1>
        <p>Create your new password</p>
    </div>
    
    <div class="auth-body">
        <div class="auth-form">
            @if (session()->has('status'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <div class="form-container">
                <form wire:submit.prevent="resetPassword">
                    <div class="form-floating">
                        <input 
                            wire:model.blur="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            placeholder="name@example.com"
                            autocomplete="email"
                            readonly
                            wire:loading.attr="disabled"
                            wire:target="resetPassword"
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
                            placeholder="New Password"
                            autocomplete="new-password"
                            wire:loading.attr="disabled"
                            wire:target="resetPassword"
                        >
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>New Password
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
                            placeholder="Confirm New Password"
                            autocomplete="new-password"
                            wire:loading.attr="disabled"
                            wire:target="resetPassword"
                        >
                        <label for="password_confirmation">
                            <i class="fas fa-lock me-2"></i>Confirm New Password
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth btn-loading" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="resetPassword">
                            <i class="fas fa-save me-2"></i>Reset Password
                        </span>
                        <span wire:loading wire:target="resetPassword">
                            <div class="spinner-custom"></div>
                            <span class="loading-text">Resetting...</span>
                        </span>
                    </button>
                </form>

                <!-- Loading overlay that doesn't affect layout -->
                <div wire:loading wire:target="resetPassword" class="loading-overlay">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0 text-muted">Resetting password...</p>
                    </div>
                </div>
            </div>

            <div class="auth-links">
                <p class="mb-0">
                    Remember your password? 
                    <a href="{{ route('login') }}" wire:navigate>
                        <i class="fas fa-sign-in-alt me-1"></i>Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
