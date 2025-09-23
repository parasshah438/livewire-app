<div>
    <div class="hero-section py-5 mb-4">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title display-4 fw-bold mb-4">
                        <span class="text-gradient">Employee Registration</span>
                    </h1>
                    <p class="hero-subtitle lead text-muted mb-0">
                        Complete the multi-step registration form to add a new employee to the system.
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
                                <i class="fas fa-user-plus me-2"></i>Registration Successful!
                            </h5>
                            <p class="mb-0 text-white-50">{{ $successMessage }}</p>
                        </div>
                        <button type="button"
                            wire:click="resetForm"
                            class="btn btn-light btn-sm ms-2">
                            Register Another
                        </button>
                    </div>
                </div>
                @endif

                @error('general')
                <div class="alert alert-danger alert-dismissible fade show mb-4 custom-alert" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger me-3"></i>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">Registration Error</h6>
                            <p class="mb-0">{{ $message }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                @enderror

                @if(!$showSuccess)
                <div class="registration-card">
                    <div class="card shadow-sm">
                        <!-- Progress Steps -->
                        <div class="card-header bg-white py-4">
                            <div class="step-progress">
                                <div class="row text-center">
                                    @for($i = 1; $i <= $totalSteps; $i++)
                                    <div class="col">
                                        <div class="step-item {{ $currentStep >= $i ? 'active' : '' }} {{ $currentStep > $i ? 'completed' : '' }}"
                                             wire:click="goToStep({{ $i }})"
                                             style="cursor: pointer;">
                                            <div class="step-circle">
                                                @if($currentStep > $i)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    {{ $i }}
                                                @endif
                                            </div>
                                            <div class="step-label">
                                                @switch($i)
                                                    @case(1) Personal Info @break
                                                    @case(2) Contact Info @break
                                                    @case(3) Employment @break
                                                    @case(4) Additional @break
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <form wire:submit="submit" enctype="multipart/form-data" novalidate>
                            <div class="card-body p-4 pb-0">
                                <!-- Step 1: Personal Information -->
                                @if($currentStep == 1)
                                <div class="step-content">
                                    <div class="step-header mb-4">
                                        <h4 class="step-title"><i class="fas fa-user me-2 text-primary"></i>Personal Information</h4>
                                        <p class="step-description text-muted">Please provide your basic personal details</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label required-label">First Name</label>
                                            <input type="text" wire:model.live="first_name" 
                                                class="form-control custom-input @error('first_name') is-invalid @enderror"
                                                placeholder="Enter first name">
                                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Last Name</label>
                                            <input type="text" wire:model.live="last_name" 
                                                class="form-control custom-input @error('last_name') is-invalid @enderror"
                                                placeholder="Enter last name">
                                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Email Address</label>
                                            <input type="email" wire:model.live="email" 
                                                class="form-control custom-input @error('email') is-invalid @enderror"
                                                placeholder="Enter email address">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" wire:model.live="phone" 
                                                class="form-control custom-input @error('phone') is-invalid @enderror"
                                                placeholder="Enter phone number">
                                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Date of Birth</label>
                                            <input type="date" wire:model.live="date_of_birth" 
                                                class="form-control custom-input @error('date_of_birth') is-invalid @enderror">
                                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Gender</label>
                                            <select wire:model.live="gender" 
                                                class="form-select custom-input @error('gender') is-invalid @enderror">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Marital Status</label>
                                            <select wire:model.live="marital_status" 
                                                class="form-select custom-input @error('marital_status') is-invalid @enderror">
                                                <option value="">Select Status</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="widowed">Widowed</option>
                                            </select>
                                            @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Nationality</label>
                                            <input type="text" wire:model.live="nationality" 
                                                class="form-control custom-input @error('nationality') is-invalid @enderror"
                                                placeholder="Enter nationality">
                                            @error('nationality') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Step 2: Contact Information -->
                                @if($currentStep == 2)
                                <div class="step-content">
                                    <div class="step-header mb-4">
                                        <h4 class="step-title"><i class="fas fa-address-book me-2 text-primary"></i>Contact Information</h4>
                                        <p class="step-description text-muted">Please provide your contact and emergency contact details</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label required-label">Address</label>
                                            <textarea wire:model.live="address" rows="3"
                                                class="form-control custom-textarea @error('address') is-invalid @enderror"
                                                placeholder="Enter full address"></textarea>
                                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">City</label>
                                            <input type="text" wire:model.live="city" 
                                                class="form-control custom-input @error('city') is-invalid @enderror"
                                                placeholder="Enter city">
                                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">State/Province</label>
                                            <input type="text" wire:model.live="state" 
                                                class="form-control custom-input @error('state') is-invalid @enderror"
                                                placeholder="Enter state/province">
                                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Postal Code</label>
                                            <input type="text" wire:model.live="postal_code" 
                                                class="form-control custom-input @error('postal_code') is-invalid @enderror"
                                                placeholder="Enter postal code">
                                            @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Country</label>
                                            <input type="text" wire:model.live="country" 
                                                class="form-control custom-input @error('country') is-invalid @enderror"
                                                placeholder="Enter country">
                                            @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12"><hr class="my-4"></div>
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3"><i class="fas fa-phone-alt me-2"></i>Emergency Contact</h5>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Emergency Contact Name</label>
                                            <input type="text" wire:model.live="emergency_contact_name" 
                                                class="form-control custom-input @error('emergency_contact_name') is-invalid @enderror"
                                                placeholder="Enter contact name">
                                            @error('emergency_contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Emergency Contact Phone</label>
                                            <input type="tel" wire:model.live="emergency_contact_phone" 
                                                class="form-control custom-input @error('emergency_contact_phone') is-invalid @enderror"
                                                placeholder="Enter contact phone">
                                            @error('emergency_contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Relationship</label>
                                            <input type="text" wire:model.live="emergency_contact_relation" 
                                                class="form-control custom-input @error('emergency_contact_relation') is-invalid @enderror"
                                                placeholder="e.g., Spouse, Parent, Sibling">
                                            @error('emergency_contact_relation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Step 3: Employment Details -->
                                @if($currentStep == 3)
                                <div class="step-content">
                                    <div class="step-header mb-4">
                                        <h4 class="step-title"><i class="fas fa-briefcase me-2 text-primary"></i>Employment Details</h4>
                                        <p class="step-description text-muted">Please provide employment-related information</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label required-label">Employee ID</label>
                                            <input type="text" wire:model.live="employee_id" 
                                                class="form-control custom-input @error('employee_id') is-invalid @enderror"
                                                placeholder="Enter employee ID">
                                            @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Department</label>
                                            <select wire:model.live="department" 
                                                class="form-select custom-input @error('department') is-invalid @enderror">
                                                <option value="">Select Department</option>
                                                <option value="Human Resources">Human Resources</option>
                                                <option value="Information Technology">Information Technology</option>
                                                <option value="Finance">Finance</option>
                                                <option value="Marketing">Marketing</option>
                                                <option value="Sales">Sales</option>
                                                <option value="Operations">Operations</option>
                                                <option value="Customer Service">Customer Service</option>
                                                <option value="Research & Development">Research & Development</option>
                                            </select>
                                            @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Position/Job Title</label>
                                            <input type="text" wire:model.live="position" 
                                                class="form-control custom-input @error('position') is-invalid @enderror"
                                                placeholder="Enter job position">
                                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Hire Date</label>
                                            <input type="date" wire:model.live="hire_date" 
                                                class="form-control custom-input @error('hire_date') is-invalid @enderror">
                                            @error('hire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Employment Type</label>
                                            <select wire:model.live="employment_type" 
                                                class="form-select custom-input @error('employment_type') is-invalid @enderror">
                                                <option value="">Select Type</option>
                                                <option value="full-time">Full-time</option>
                                                <option value="part-time">Part-time</option>
                                                <option value="contract">Contract</option>
                                                <option value="intern">Intern</option>
                                            </select>
                                            @error('employment_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Employment Status</label>
                                            <select wire:model.live="employment_status" 
                                                class="form-select custom-input @error('employment_status') is-invalid @enderror">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="terminated">Terminated</option>
                                                <option value="on-leave">On Leave</option>
                                            </select>
                                            @error('employment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Annual Salary ($)</label>
                                            <input type="number" wire:model.live="salary" step="0.01" min="0"
                                                class="form-control custom-input @error('salary') is-invalid @enderror"
                                                placeholder="Enter annual salary">
                                            @error('salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Manager/Supervisor</label>
                                            <input type="text" wire:model.live="manager" 
                                                class="form-control custom-input @error('manager') is-invalid @enderror"
                                                placeholder="Enter manager name">
                                            @error('manager') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Work Location</label>
                                            <input type="text" wire:model.live="work_location" 
                                                class="form-control custom-input @error('work_location') is-invalid @enderror"
                                                placeholder="Enter work location">
                                            @error('work_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label required-label">Start Time</label>
                                            <input type="time" wire:model.live="work_start_time" 
                                                class="form-control custom-input @error('work_start_time') is-invalid @enderror">
                                            @error('work_start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label required-label">End Time</label>
                                            <input type="time" wire:model.live="work_end_time" 
                                                class="form-control custom-input @error('work_end_time') is-invalid @enderror">
                                            @error('work_end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Working Days</label>
                                            <div class="row g-2">
                                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               wire:model.live="work_days" value="{{ $day }}" 
                                                               id="day_{{ $day }}">
                                                        <label class="form-check-label" for="day_{{ $day }}">
                                                            {{ ucfirst($day) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Step 4: Additional Information -->
                                @if($currentStep == 4)
                                <div class="step-content">
                                    <div class="step-header mb-4">
                                        <h4 class="step-title"><i class="fas fa-plus-circle me-2 text-primary"></i>Additional Information</h4>
                                        <p class="step-description text-muted">Please provide additional details and documents</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label required-label">Highest Education</label>
                                            <select wire:model.live="highest_education" 
                                                class="form-select custom-input @error('highest_education') is-invalid @enderror">
                                                <option value="">Select Education Level</option>
                                                <option value="High School">High School</option>
                                                <option value="Associate Degree">Associate Degree</option>
                                                <option value="Bachelor's Degree">Bachelor's Degree</option>
                                                <option value="Master's Degree">Master's Degree</option>
                                                <option value="Doctoral Degree">Doctoral Degree</option>
                                                <option value="Professional Certification">Professional Certification</option>
                                            </select>
                                            @error('highest_education') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">University/Institution</label>
                                            <input type="text" wire:model.live="university" 
                                                class="form-control custom-input @error('university') is-invalid @enderror"
                                                placeholder="Enter university name">
                                            @error('university') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Graduation Year</label>
                                            <input type="number" wire:model.live="graduation_year" min="1950" max="2024"
                                                class="form-control custom-input @error('graduation_year') is-invalid @enderror"
                                                placeholder="Enter graduation year">
                                            @error('graduation_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Years of Experience</label>
                                            <input type="number" wire:model.live="experience_years" min="0" max="50"
                                                class="form-control custom-input @error('experience_years') is-invalid @enderror"
                                                placeholder="Enter years of experience">
                                            @error('experience_years') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Skills</label>
                                            <textarea wire:model.live="skills" rows="3"
                                                class="form-control custom-textarea @error('skills') is-invalid @enderror"
                                                placeholder="List your technical and professional skills"></textarea>
                                            @error('skills') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Certifications</label>
                                            <textarea wire:model.live="certifications" rows="2"
                                                class="form-control custom-textarea @error('certifications') is-invalid @enderror"
                                                placeholder="List any professional certifications"></textarea>
                                            @error('certifications') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Profile Photo</label>
                                            <input type="file" wire:model.live="profile_photo" accept="image/*"
                                                class="form-control custom-input @error('profile_photo') is-invalid @enderror">
                                            @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <small class="form-text text-muted">Max file size: 2MB</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Resume</label>
                                            <input type="file" wire:model.live="resume" accept=".pdf,.doc,.docx"
                                                class="form-control custom-input @error('resume') is-invalid @enderror">
                                            @error('resume') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <small class="form-text text-muted">Max file size: 5MB (PDF, DOC, DOCX)</small>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Languages</label>
                                            <div class="row g-2">
                                                @foreach(['english', 'spanish', 'french', 'german', 'mandarin', 'japanese', 'arabic', 'hindi'] as $language)
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               wire:model.live="languages" value="{{ $language }}" 
                                                               id="lang_{{ $language }}">
                                                        <label class="form-check-label" for="lang_{{ $language }}">
                                                            {{ ucfirst($language) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Hobbies & Interests</label>
                                            <textarea wire:model.live="hobbies" rows="2"
                                                class="form-control custom-textarea @error('hobbies') is-invalid @enderror"
                                                placeholder="Tell us about your hobbies and interests"></textarea>
                                            @error('hobbies') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               wire:model.live="has_driving_license" id="driving_license">
                                                        <label class="form-check-label" for="driving_license">
                                                            Has Driving License
                                                        </label>
                                                    </div>
                                                    @if($has_driving_license)
                                                    <input type="text" wire:model.live="driving_license_number" 
                                                        class="form-control custom-input mt-2 @error('driving_license_number') is-invalid @enderror"
                                                        placeholder="Enter license number">
                                                    @error('driving_license_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" 
                                                               wire:model.live="willing_to_relocate" id="relocate">
                                                        <label class="form-check-label" for="relocate">
                                                            Willing to Relocate
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               wire:model.live="willing_to_travel" id="travel">
                                                        <label class="form-check-label" for="travel">
                                                            Willing to Travel
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required-label">Notice Period (Days)</label>
                                            <input type="number" wire:model.live="notice_period_days" min="0" max="365"
                                                class="form-control custom-input @error('notice_period_days') is-invalid @enderror"
                                                placeholder="Enter notice period in days">
                                            @error('notice_period_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Additional Notes</label>
                                            <textarea wire:model.live="notes" rows="3"
                                                class="form-control custom-textarea @error('notes') is-invalid @enderror"
                                                placeholder="Any additional information or notes"></textarea>
                                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="card-footer bg-white py-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="step-info">
                                            <small class="text-muted">
                                                Step {{ $currentStep }} of {{ $totalSteps }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="step-navigation text-md-end">
                                            @if($currentStep > 1)
                                            <button type="button" wire:click="previousStep" 
                                                class="btn btn-outline-secondary me-2">
                                                <i class="fas fa-arrow-left me-1"></i>Previous
                                            </button>
                                            @endif

                                            @if($currentStep < $totalSteps)
                                            <button type="button" wire:click="nextStep" 
                                                class="btn btn-primary">
                                                Next<i class="fas fa-arrow-right ms-1"></i>
                                            </button>
                                            @else
                                            <button type="submit" 
                                                class="btn btn-success px-4"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="submit">
                                                    <i class="fas fa-check me-1"></i>Complete Registration
                                                </span>
                                                <span wire:loading wire:target="submit">
                                                    <span class="spinner-border spinner-border-sm me-2"></span>Processing...
                                                </span>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* FORCE ALL INPUTS TO BE VISIBLE AND FUNCTIONAL ALWAYS */
        .custom-input,
        .custom-textarea,
        .form-select {
            display: block !important;
            width: 100% !important;
            height: auto !important;
            padding: 0.75rem 1rem !important;
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
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Override any Bootstrap or other framework styles */
        .custom-input:not([disabled]):not([readonly]),
        .custom-textarea:not([disabled]):not([readonly]),
        .form-select:not([disabled]):not([readonly]) {
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
            background-color: #ffffff !important;
            color: #212529 !important;
            border: 2px solid #dee2e6 !important;
        }

        .custom-input:focus,
        .custom-textarea:focus,
        .form-select:focus {
            color: #212529 !important;
            background-color: #ffffff !important;
            border-color: #667eea !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25) !important;
            cursor: text !important;
            pointer-events: auto !important;
        }

        .custom-input:hover:not(:disabled),
        .custom-textarea:hover:not(:disabled),
        .form-select:hover:not(:disabled) {
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
        .custom-textarea[disabled],
        .form-select[disabled] {
            background-color: #f8f9fa !important;
            border-color: #e9ecef !important;
            opacity: 0.65 !important;
            cursor: not-allowed !important;
            color: #6c757d !important;
        }

        .custom-textarea {
            min-height: 100px !important;
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
        .custom-textarea.is-valid,
        .form-select.is-valid {
            border-color: #198754 !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
        }

        .custom-input.is-valid:focus,
        .custom-textarea.is-valid:focus,
        .form-select.is-valid:focus {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
        }

        .custom-input.is-invalid,
        .custom-textarea.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545 !important;
            color: #212529 !important;
            background-color: #ffffff !important;
            cursor: text !important;
            pointer-events: auto !important;
            user-select: text !important;
        }

        .custom-input.is-invalid:focus,
        .custom-textarea.is-invalid:focus,
        .form-select.is-invalid:focus {
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
        .form-select,
        .custom-input:active,
        .custom-textarea:active,
        .form-select:active,
        .custom-input:focus,
        .custom-textarea:focus,
        .form-select:focus,
        .custom-input.is-valid,
        .custom-textarea.is-valid,
        .form-select.is-valid,
        .custom-input.is-invalid,
        .custom-textarea.is-invalid,
        .form-select.is-invalid {
            pointer-events: auto !important;
            cursor: text !important;
            user-select: text !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Prevent any form validation from disabling inputs */
        .was-validated .custom-input:not([disabled]),
        .was-validated .custom-textarea:not([disabled]),
        .was-validated .form-select:not([disabled]) {
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

        /* Step Progress */
        .step-progress {
            position: relative;
            margin: 0 2rem;
        }

        .step-progress::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .step-item {
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 auto 0.5rem;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
        }

        .step-item.active .step-circle {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .step-item.completed .step-circle {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
        }

        .step-item.active .step-label {
            color: #667eea;
        }

        .step-item.completed .step-label {
            color: #28a745;
        }

        /* Step content */
        .step-content {
            min-height: 400px;
        }

        .step-header {
            text-align: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .step-title {
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .step-description {
            font-size: 1rem;
        }

        /* Card styling */
        .registration-card .card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        /* Success alert */
        .custom-alert.alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
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

        /* Form check styling - FORCE VISIBILITY */
        .form-check {
            margin-bottom: 0.5rem;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .form-check-input {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            pointer-events: auto !important;
            cursor: pointer !important;
        }

        .form-check-input:checked {
            background-color: #667eea !important;
            border-color: #667eea !important;
        }

        .form-check-input:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25) !important;
        }

        .form-check-label {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            cursor: pointer !important;
        }

        /* Button styling */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            color: white !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            color: white !important;
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .step-progress {
                margin: 0 1rem;
            }
            
            .step-circle {
                width: 35px;
                height: 35px;
            }
            
            .step-label {
                font-size: 0.75rem;
            }
            
            .step-navigation .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .step-navigation .btn:last-child {
                margin-bottom: 0;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 2rem 0;
            }
            
            .card-body {
                padding: 1.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Employee Registration Form Loading...');

            // Function to ensure all form inputs are always visible and functional
            function makeAllInputsFunctional() {
                const inputs = document.querySelectorAll('.custom-input, .custom-textarea, .form-select, .form-check-input');
                
                inputs.forEach(input => {
                    // Force visibility and functionality
                    input.style.display = 'block';
                    input.style.visibility = 'visible';
                    input.style.opacity = '1';
                    input.style.pointerEvents = 'auto';
                    input.style.userSelect = 'text';
                    input.style.cursor = input.type === 'checkbox' || input.type === 'radio' ? 'pointer' : 'text';
                    input.style.backgroundColor = '#ffffff';
                    input.style.color = '#212529';
                    
                    // Remove any problematic attributes
                    if (!input.dataset.originalDisabled) {
                        input.removeAttribute('disabled');
                        input.removeAttribute('readonly');
                    }
                    
                    // Special handling for select elements
                    if (input.tagName === 'SELECT') {
                        input.style.cursor = 'pointer';
                    }
                });
                
                console.log('Made', inputs.length, 'inputs functional');
            }

            // Function to make form checks visible
            function makeFormChecksVisible() {
                const formChecks = document.querySelectorAll('.form-check');
                formChecks.forEach(check => {
                    check.style.display = 'block';
                    check.style.visibility = 'visible';
                    check.style.opacity = '1';
                });

                const checkInputs = document.querySelectorAll('.form-check-input');
                checkInputs.forEach(input => {
                    input.style.display = 'inline-block';
                    input.style.visibility = 'visible';
                    input.style.opacity = '1';
                    input.style.pointerEvents = 'auto';
                    input.style.cursor = 'pointer';
                });

                const checkLabels = document.querySelectorAll('.form-check-label');
                checkLabels.forEach(label => {
                    label.style.display = 'inline-block';
                    label.style.visibility = 'visible';
                    label.style.opacity = '1';
                    label.style.cursor = 'pointer';
                });
            }

            // Run immediately
            makeAllInputsFunctional();
            makeFormChecksVisible();

            // Run after a short delay to catch any late-loading elements
            setTimeout(() => {
                makeAllInputsFunctional();
                makeFormChecksVisible();
                console.log('Second pass completed');
            }, 500);

            // Run periodically to maintain functionality
            setInterval(() => {
                makeAllInputsFunctional();
                makeFormChecksVisible();
            }, 2000);

            // Listen for Livewire updates
            document.addEventListener('livewire:initialized', () => {
                console.log('Livewire initialized');
                
                // Handle Livewire navigation updates
                Livewire.hook('morph.updated', ({ component, cleanup }) => {
                    console.log('Livewire component updated');
                    setTimeout(() => {
                        makeAllInputsFunctional();
                        makeFormChecksVisible();
                    }, 100);
                });
            });

            // Additional safety nets
            document.addEventListener('DOMContentLoaded', () => {
                makeAllInputsFunctional();
                makeFormChecksVisible();
            });

            window.addEventListener('load', () => {
                makeAllInputsFunctional();
                makeFormChecksVisible();
            });

            // Test input functionality every few seconds
            setInterval(() => {
                const firstInput = document.querySelector('.custom-input');
                if (firstInput) {
                    const computedStyle = window.getComputedStyle(firstInput);
                    if (computedStyle.pointerEvents === 'none' || computedStyle.display === 'none') {
                        console.log('Input issue detected, fixing...');
                        makeAllInputsFunctional();
                        makeFormChecksVisible();
                    }
                }
            }, 3000);
        });
    </script>
</div>