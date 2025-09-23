<div>
    <div class="hero-section py-5 mb-4">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title display-4 fw-bold mb-4">
                        <span class="text-gradient">Get In Touch</span>
                    </h1>
                    <p class="hero-subtitle lead text-muted mb-0">
                        Have questions or need assistance? We're here to help!
                        Send us a message and we'll respond within 24 hours.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                @if($showSuccess)
                <div class="alert alert-success alert-dismissible fade show mb-4 custom-alert"
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <div class="success-icon-wrapper me-3">
                            <i class="fas fa-check-circle fa-2x text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading fw-bold mb-1 text-white">
                                <i class="fas fa-rocket me-2"></i>Message Sent Successfully!
                            </h5>
                            <p class="mb-0 text-white-50">{{ $successMessage }}</p>
                        </div>
                        <button type="button"
                            wire:click="hideSuccess"
                            class="btn-close btn-close-white ms-2"
                            aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @error('general')
                <div class="alert alert-danger alert-dismissible fade show mb-4 custom-alert" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger me-3"></i>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">Oops! Something went wrong</h6>
                            <p class="mb-0">{{ $message }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                @enderror

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="contact-info-card h-100">
                            <div class="card h-100 shadow-sm contact-card">
                                <div class="card-body p-4">
                                    <h4 class="card-title fw-bold mb-4 text-primary">
                                        <i class="fas fa-address-card me-2"></i>Contact Information
                                    </h4>

                                    <div class="contact-item mb-4">
                                        <div class="contact-item-icon mb-3">
                                            <i class="fas fa-envelope-open text-primary"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-2">Email Address</h6>
                                        <p class="text-muted mb-0">
                                            <a href="mailto:info@company.com" class="text-decoration-none text-primary">
                                                info@company.com
                                            </a>
                                        </p>
                                    </div>

                                    <div class="contact-item mb-4">
                                        <div class="contact-item-icon mb-3">
                                            <i class="fas fa-phone text-primary"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-2">Phone Number</h6>
                                        <p class="text-muted mb-0">
                                            <a href="tel:+15551234567" class="text-decoration-none text-primary">
                                                +1 (555) 123-4567
                                            </a>
                                        </p>
                                    </div>

                                    <div class="contact-item mb-4">
                                        <div class="contact-item-icon mb-3">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-2">Office Address</h6>
                                        <p class="text-muted mb-0">
                                            123 Business Street<br>
                                            Suite 100<br>
                                            New York, NY 10001
                                        </p>
                                    </div>

                                    <div class="contact-item">
                                        <div class="contact-item-icon mb-3">
                                            <i class="fas fa-clock text-primary"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-2">Business Hours</h6>
                                        <p class="text-muted mb-0">
                                            Monday - Friday: 9:00 AM - 6:00 PM<br>
                                            Saturday: 10:00 AM - 4:00 PM<br>
                                            Sunday: Closed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="contact-form-card">
                            <div class="card shadow-sm contact-card">
                                <div class="card-header bg-white py-4">
                                    <h4 class="card-title fw-bold mb-0 text-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Send Us a Message
                                    </h4>
                                    <p class="text-muted mb-0 mt-2">
                                        Fill out the form below and we'll get back to you as soon as possible.
                                    </p>
                                </div>

                                <div class="card-body p-4">
                                    {{-- Loading Overlay --}}
                                    <div wire:loading wire:target="submit" class="loading-overlay">
                                        <div class="loading-content">
                                            <div class="spinner-border text-primary mb-3" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <h5 class="fw-bold text-primary">Sending your message...</h5>
                                            <p class="text-muted mb-0">Please wait while we process your request.</p>
                                        </div>
                                    </div>

                                    <form wire:submit="submit" novalidate class="contact-form">

                                        {{-- Name and Email Row --}}
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label required-label">
                                                    <i class="fas fa-user me-2 text-primary"></i>Full Name
                                                </label>
                                                <input type="text"
                                                    id="name"
                                                    wire:model.live.debounce.300ms="name"
                                                    class="form-control custom-input @error('name') is-invalid @enderror"
                                                    placeholder="Enter your full name"
                                                    maxlength="100"
                                                    required>
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="email" class="form-label required-label">
                                                    <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                                                </label>
                                                <input type="email"
                                                    id="email"
                                                    wire:model.live.debounce.300ms="email"
                                                    class="form-control custom-input @error('email') is-invalid @enderror"
                                                    placeholder="Enter your email address"
                                                    maxlength="150"
                                                    required>
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Phone and Subject Row --}}
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">
                                                    <i class="fas fa-phone me-2 text-primary"></i>Phone Number
                                                    <small class="text-muted">(Optional)</small>
                                                </label>
                                                <input type="tel"
                                                    id="phone"
                                                    wire:model.live.debounce.300ms="phone"
                                                    class="form-control custom-input @error('phone') is-invalid @enderror"
                                                    placeholder="Enter your phone number"
                                                    maxlength="20">
                                                @error('phone')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="subject" class="form-label required-label">
                                                    <i class="fas fa-tag me-2 text-primary"></i>Subject
                                                </label>
                                                <input type="text"
                                                    id="subject"
                                                    wire:model.live.debounce.300ms="subject"
                                                    class="form-control custom-input @error('subject') is-invalid @enderror"
                                                    placeholder="What is this regarding?"
                                                    maxlength="200"
                                                    required>
                                                @error('subject')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Message Field --}}
                                        <div class="mb-4">
                                            <label for="message" class="form-label required-label">
                                                <i class="fas fa-comment-dots me-2 text-primary"></i>Message
                                            </label>
                                            <textarea id="message"
                                                wire:model.live.debounce.500ms="message"
                                                class="form-control custom-textarea @error('message') is-invalid @enderror"
                                                placeholder="Tell us more about your inquiry... Please provide as much detail as possible to help us assist you better."
                                                rows="5"
                                                maxlength="2000"
                                                required></textarea>

                                            <div class="form-text d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Minimum 10 characters required
                                                </small>
                                                <small class="character-count">
                                                    {{ strlen($message) }}/2000
                                                </small>
                                            </div>

                                            @error('message')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        {{-- Submit Section --}}
                                        <div class="submit-section">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <div class="privacy-notice">
                                                        <small class="text-muted">
                                                            <i class="fas fa-shield-alt me-1 text-success"></i>
                                                            Your information is secure and will not be shared.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-lg px-4 py-3 fw-semibold custom-submit-btn"
                                                        wire:loading.attr="disabled">
                                                        <span wire:loading.remove wire:target="submit">
                                                            <i class="fas fa-paper-plane me-2"></i>Send Message
                                                        </span>
                                                        <span wire:loading wire:target="submit">
                                                            <span class="spinner-border spinner-border-sm me-2"></span>Sending...
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5 g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card text-center">
                            <div class="card h-100 shadow-sm feature-item">
                                <div class="card-body p-4">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-headset fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">24/7 Support</h6>
                                    <p class="text-muted small mb-0">Round-the-clock assistance when you need it most.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card text-center">
                            <div class="card h-100 shadow-sm feature-item">
                                <div class="card-body p-4">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-reply fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Quick Response</h6>
                                    <p class="text-muted small mb-0">We respond to all inquiries within 24 hours.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card text-center">
                            <div class="card h-100 shadow-sm feature-item">
                                <div class="card-body p-4">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-user-tie fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Expert Team</h6>
                                    <p class="text-muted small mb-0">Professional team ready to solve your challenges.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card text-center">
                            <div class="card h-100 shadow-sm feature-item">
                                <div class="card-body p-4">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-lock fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Secure & Private</h6>
                                    <p class="text-muted small mb-0">Your data is protected with enterprise-grade security.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Force all inputs to be functional at all times */
        .custom-input,
        .custom-textarea {
            display: block !important;
            width: 100% !important;
            height: auto !important;
            padding: 0.875rem 1rem !important;
            font-size: 1rem !important;
            font-weight: 400 !important;
            line-height: 1.5 !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            background-image: none !important;
            border: 2px solid #dee2e6 !important;
            border-radius: 0.5rem !important;
            appearance: none !important;
            transition: all 0.15s ease-in-out !important;
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
        }

        /* Override any Bootstrap or other framework styles */
        .custom-input:not([disabled]):not([readonly]),
        .custom-textarea:not([disabled]):not([readonly]) {
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
            background-color: #ffffff !important;
            color: #212529 !important;
        }

        .custom-input:focus,
        .custom-textarea:focus {
            color: #212529 !important;
            background-color: #ffffff !important;
            border-color: #667eea !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25) !important;
            cursor: text !important;
            pointer-events: auto !important;
        }

        .custom-input:hover:not(:disabled),
        .custom-textarea:hover:not(:disabled) {
            border-color: #adb5bd !important;
            cursor: text !important;
        }

        .custom-input::placeholder,
        .custom-textarea::placeholder {
            color: #6c757d !important;
            opacity: 1 !important;
        }

        /* Only truly disabled inputs should look disabled */
        .custom-input[disabled],
        .custom-textarea[disabled] {
            background-color: #f8f9fa !important;
            border-color: #e9ecef !important;
            opacity: 0.65 !important;
            cursor: not-allowed !important;
            color: #6c757d !important;
        }

        .custom-textarea {
            min-height: 120px !important;
            resize: vertical !important;
        }

        /* Form labels */
        .form-label {
            display: block !important;
            margin-bottom: 0.5rem !important;
            font-weight: 600 !important;
            color: #374151 !important;
            font-size: 0.95rem !important;
        }

        .required-label::after {
            content: " *";
            color: #dc3545;
            font-weight: bold;
        }

        /* Validation styles - ALWAYS keep inputs functional */
        .custom-input.is-valid,
        .custom-textarea.is-valid {
            border-color: #198754 !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
        }

        .custom-input.is-valid:focus,
        .custom-textarea.is-valid:focus {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
        }

        .custom-input.is-invalid,
        .custom-textarea.is-invalid {
            border-color: #dc3545 !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
        }

        .custom-input.is-invalid:focus,
        .custom-textarea.is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
        }

        /* Force functionality for all states */
        .custom-input,
        .custom-textarea,
        .custom-input:active,
        .custom-textarea:active,
        .custom-input:focus,
        .custom-textarea:focus,
        .custom-input.is-valid,
        .custom-textarea.is-valid,
        .custom-input.is-invalid,
        .custom-textarea.is-invalid {
            pointer-events: auto !important;
            cursor: text !important;
            user-select: text !important;
        }

        /* Prevent any form validation from disabling inputs */
        .was-validated .custom-input:not([disabled]),
        .was-validated .custom-textarea:not([disabled]) {
            pointer-events: auto !important;
            cursor: text !important;
            user-select: text !important;
            background-color: #ffffff !important;
            color: #212529 !important;
        }

        /* Invalid feedback */
        .invalid-feedback {
            display: block !important;
            width: 100% !important;
            margin-top: 0.25rem !important;
            font-size: 0.875rem !important;
            color: #dc3545 !important;
            font-weight: 500 !important;
        }

        /* Hero section */
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            border-radius: 0 0 1.5rem 1.5rem;
        }

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Cards */
        .contact-card {
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            border-radius: 1rem !important;
            transition: all 0.3s ease !important;
        }

        .contact-card:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.1) !important;
        }

        /* Custom button */
        .custom-submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            border-radius: 0.75rem !important;
            color: white !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.3) !important;
            min-width: 180px !important;
        }

        .custom-submit-btn:hover:not(:disabled) {
            transform: translateY(-2px) !important;
            box-shadow: 0 0.75rem 1.5rem rgba(102, 126, 234, 0.4) !important;
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
        }

        .custom-submit-btn:disabled {
            opacity: 0.7 !important;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Loading overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
        }

        .loading-content {
            text-align: center;
            padding: 2rem;
        }

        /* Contact info styling */
        .contact-item {
            padding: 1rem;
            border-radius: 0.75rem;
            background: rgba(102, 126, 234, 0.05);
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .contact-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(5px);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .contact-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Success alert */
        .custom-alert.alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 1rem !important;
            padding: 1.5rem !important;
        }

        .success-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Character counter */
        .character-count {
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #6c757d;
        }

        /* Feature cards */
        .feature-item {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 1rem !important;
            transition: all 0.3s ease !important;
        }

        .feature-item:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
            background: rgba(102, 126, 234, 0.02) !important;
        }

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem !important;
            }

            .custom-submit-btn {
                width: 100% !important;
                min-width: unset !important;
            }

            .submit-section .row {
                text-align: center;
            }

            .privacy-notice {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 2rem 0 !important;
            }

            .card-body {
                padding: 1.5rem !important;
            }
        }

        /* Form positioning */
        .contact-form {
            position: relative;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.contact-form');
            const inputs = form.querySelectorAll('.custom-input, .custom-textarea');

            //Function to ensure input is always functional
            function makeInputFunctional(input) {
                input.style.display = 'block';
                input.style.visibility = 'visible';
                input.style.opacity = '1';
                input.style.cursor = 'text';
                input.style.pointerEvents = 'auto';
                input.style.userSelect = 'text';
                input.style.webkitUserSelect = 'text';
                input.style.mozUserSelect = 'text';
                input.style.msUserSelect = 'text';
                input.style.backgroundColor = '#ffffff';
                input.style.color = '#212529';

                // Remove any disabled attributes that might interfere
                input.removeAttribute('readonly');
                if (!input.dataset.originalDisabled) {
                    input.removeAttribute('disabled');
                }
            }

            // Ensure all inputs are functional initially
            inputs.forEach((input, index) => {

                makeInputFunctional(input);

                // SIMPLE event listeners - focus on functionality first
                input.addEventListener('input', function(e) {
                    makeInputFunctional(this);
                    updateCharacterCount(this);

                    // Very basic validation - only if field has errors already
                    if (this.classList.contains('is-invalid') && this.value.trim().length > 0) {
                        setTimeout(() => validateField(this, true), 100);
                    }
                });

                input.addEventListener('focus', function() {
                    makeInputFunctional(this);
                    // Remove invalid class on focus to give fresh start
                    this.classList.remove('is-invalid');
                });

                input.addEventListener('click', function() {
                    makeInputFunctional(this);
                });

                input.addEventListener('keydown', function(e) {
                    makeInputFunctional(this);
                    // Explicitly allow the keypress
                    return true;
                });
            });

            // Form reset function
            function resetFormFields() {

                inputs.forEach(input => {
                    // Clear the value
                    input.value = '';

                    // Remove validation classes
                    input.classList.remove('is-valid', 'is-invalid');

                    // Trigger input event to update Livewire
                    input.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                });

                // Reset character counter
                const counter = document.querySelector('.character-count');
                if (counter) {
                    counter.textContent = '0/2000';
                    counter.style.color = '#6c757d';
                }

                // Remove form validation class
                form.classList.remove('was-validated');
            }

            function validateField(field, showValidation = true) {
                const value = field.value.trim();
                const fieldName = field.id;
                let isValid = true;

                // Always remove existing validation classes first
                field.classList.remove('is-valid', 'is-invalid');

                // Skip validation entirely if field is empty and optional
                if (!value && fieldName === 'phone') {
                    return true;
                }

                // Don't show validation for required fields until they have some content or on blur
                if (!value && (fieldName === 'name' || fieldName === 'email' || fieldName === 'subject' || fieldName === 'message')) {
                    return true;
                }

                // Validation rules - FIXED REGEX
                switch (fieldName) {
                    case 'name':
                        // Simple name validation - letters, spaces, hyphens, dots, apostrophes
                        isValid = value.length >= 2 && value.length <= 100 && /^[a-zA-ZÀ-ÿ\s\-\.\']+$/.test(value);
                        break;
                    case 'email':
                        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) && value.length <= 150;
                        break;
                    case 'phone':
                        isValid = value.length === 0 || (/^[\+]?[0-9\s\-\(\)]+$/.test(value) && value.length <= 20);
                        break;
                    case 'subject':
                        isValid = value.length >= 5 && value.length <= 200;
                        break;
                    case 'message':
                        isValid = value.length >= 10 && value.length <= 2000;
                        break;
                }

                // Only apply validation classes if we should show validation and field has content
                if (showValidation && value.length > 0) {
                    field.classList.add(isValid ? 'is-valid' : 'is-invalid');
                }

                return isValid;
            }

            function updateCharacterCount(field) {
                if (field.id === 'message') {
                    const counter = document.querySelector('.character-count');
                    if (counter) {
                        const count = field.value.length;
                        counter.textContent = count + '/2000';

                        // Update color based on usage
                        counter.style.color = count > 1800 ? '#dc3545' : count > 1500 ? '#fd7e14' : '#6c757d';
                    }
                }
            }

            // Form submission - SIMPLIFIED
            form.addEventListener('submit', function(e) {
                let isFormValid = true;
                const requiredFields = form.querySelectorAll('input[required], textarea[required]');

                // Simple validation - just check if required fields are empty
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isFormValid = false;
                        field.classList.add('is-invalid');
                        field.classList.remove('is-valid');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                if (!isFormValid) {

                    e.preventDefault();
                    e.stopPropagation();

                    // Make sure ALL inputs are functional after validation
                    inputs.forEach(input => {
                        makeInputFunctional(input);
                    });

                    // Focus first empty required field
                    const firstEmpty = Array.from(requiredFields).find(field => !field.value.trim());
                    if (firstEmpty) {
                        makeInputFunctional(firstEmpty);
                        setTimeout(() => {
                            firstEmpty.focus();
                        }, 100);
                    }

                    // Additional safety - re-enable all inputs after a delay
                    setTimeout(() => {
                        inputs.forEach(input => {
                            makeInputFunctional(input);
                        });
                    }, 500);

                }
            });

            // Safety net - check inputs every 3 seconds
            setInterval(() => {
                inputs.forEach(input => {
                    if (window.getComputedStyle(input).pointerEvents === 'none' ||
                        window.getComputedStyle(input).cursor !== 'text') {
                        makeInputFunctional(input);
                    }
                });
            }, 3000);

            // Additional test after page load
            setTimeout(() => {
                inputs.forEach(input => {


                    // Try to focus and see if it works
                    try {
                        input.focus();
                        input.blur();
                    } catch (e) {

                    }
                });
            }, 1000);

            // Listen for Livewire events
            document.addEventListener('livewire:initialized', () => {

                // Listen for form submission success
                Livewire.on('form-submitted', () => {

                    // Small delay to ensure Livewire has updated
                    setTimeout(() => {
                        resetFormFields();

                        // Scroll to top to show success message
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 100);
                });
            });
        });
    </script>
</div>