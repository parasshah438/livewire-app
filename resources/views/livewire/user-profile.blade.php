<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Header -->
                <div class="profile-card p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="profile-avatar mb-3">
                                <img 
                                    src="{{ auth()->user()->profile_photo_url }}" 
                                    alt="{{ auth()->user()->name }}"
                                    class="rounded-circle"
                                    width="120" 
                                    height="120"
                                    style="object-fit: cover; border: 3px solid rgba(255,255,255,0.2);"
                                >
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="text-white mb-1">{{ auth()->user()->name }}</h2>
                            <p class="text-white-75 mb-0">
                                <i class="fas fa-envelope me-2"></i>{{ auth()->user()->email }}
                            </p>
                            <p class="text-white-75 small mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Member since {{ auth()->user()->created_at->format('M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Profile Update Form -->
                <div class="profile-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white mb-0">
                            <i class="fas fa-user-edit me-2"></i>Profile Information
                        </h4>
                    </div>

                    <!-- Success Message -->
                    @if($profileUpdated)
                        <div class="alert alert-success-custom d-flex align-items-center mb-4" role="alert">
                            <div class="alert-icon me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">Profile Updated!</h6>
                                <p class="mb-0">Your profile information has been updated successfully.</p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit.prevent="updateProfile">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name"
                                    wire:model.blur="name"
                                    placeholder="Enter your full name"
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email"
                                    wire:model.blur="email"
                                    placeholder="Enter your email address"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="profile_photo" class="form-label">
                                    <i class="fas fa-camera me-2"></i>Profile Photo
                                </label>
                                <input 
                                    type="file" 
                                    class="form-control @error('profile_photo') is-invalid @enderror" 
                                    id="profile_photo"
                                    wire:model="profile_photo"
                                    accept="image/*"
                                >
                                @error('profile_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                @if ($profile_photo)
                                    <div class="mt-2">
                                        <small class="text-white-75">Photo Preview:</small>
                                        <div class="d-flex align-items-center mt-1">
                                            <img src="{{ $profile_photo->temporaryUrl() }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                                            <span class="text-white ms-2">{{ $profile_photo->getClientOriginalName() }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button 
                                type="submit" 
                                class="btn btn-success-gradient"
                                wire:loading.attr="disabled"
                                wire:target="updateProfile"
                            >
                                <span wire:loading.remove wire:target="updateProfile">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </span>
                                <span wire:loading wire:target="updateProfile">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="profile-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white mb-0">
                            <i class="fas fa-lock me-2"></i>Security Settings
                        </h4>
                        <button 
                            class="btn btn-secondary-gradient btn-sm"
                            wire:click="togglePasswordForm"
                        >
                            @if($showPasswordForm)
                                <i class="fas fa-times me-2"></i>Cancel
                            @else
                                <i class="fas fa-key me-2"></i>Change Password
                            @endif
                        </button>
                    </div>

                    <!-- Password Success Message -->
                    @if($passwordChanged)
                        <div class="alert alert-success-custom d-flex align-items-center mb-4" role="alert">
                            <div class="alert-icon me-3">
                                <i class="fas fa-shield-check fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">Password Updated!</h6>
                                <p class="mb-0">Your password has been changed successfully.</p>
                            </div>
                        </div>
                    @endif

                    @if($showPasswordForm)
                        <form wire:submit.prevent="updatePassword">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-unlock-alt me-2"></i>Current Password
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control @error('current_password') is-invalid @enderror" 
                                        id="current_password"
                                        wire:model.blur="current_password"
                                        placeholder="Enter your current password"
                                    >
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>New Password
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        id="password"
                                        wire:model.blur="password"
                                        placeholder="Enter new password"
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirm Password
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation"
                                        wire:model.blur="password_confirmation"
                                        placeholder="Confirm new password"
                                    >
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Requirements Note -->
                            <div class="alert alert-info-custom d-flex align-items-center mb-3" role="alert">
                                <div class="alert-icon me-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="mb-0">
                                        <strong>Password Requirements:</strong> Minimum 8 characters, must be different from your current password.
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-light"
                                    wire:click="togglePasswordForm"
                                >
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    class="btn btn-gradient"
                                    wire:loading.attr="disabled"
                                    wire:target="updatePassword"
                                >
                                    <span wire:loading.remove wire:target="updatePassword">
                                        <i class="fas fa-key me-2"></i>Change Password
                                    </span>
                                    <span wire:loading wire:target="updatePassword">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Changing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shield-alt fa-3x text-white-75 mb-3"></i>
                            <p class="text-white-75 mb-0">
                                Your password is secure. Click "Change Password" to update it.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-avatar {
            transition: all 0.3s ease;
        }
        
        .profile-avatar:hover {
            transform: scale(1.05);
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
        }
        
        .invalid-feedback {
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            padding: 8px 12px;
            margin-top: 5px;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</div>
