<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeRegistration extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;

    // Step 1: Personal Information
    #[Rule('required|string|min:2|max:100')]
    public $first_name = '';
    
    #[Rule('required|string|min:2|max:100')]
    public $last_name = '';
    
    #[Rule('required|email|max:150|unique:employees,email')]
    public $email = '';
    
    #[Rule('nullable|string|max:20')]
    public $phone = '';
    
    #[Rule('required|date|before_or_equal:today')]
    public $date_of_birth = '';
    
    #[Rule('required|in:male,female,other')]
    public $gender = '';
    
    #[Rule('required|in:single,married,divorced,widowed')]
    public $marital_status = '';
    
    #[Rule('required|string|max:100')]
    public $nationality = '';

    // Step 2: Contact Information
    #[Rule('required|string|max:500')]
    public $address = '';
    
    #[Rule('required|string|max:100')]
    public $city = '';
    
    #[Rule('required|string|max:100')]
    public $state = '';
    
    #[Rule('required|string|max:20')]
    public $postal_code = '';
    
    #[Rule('required|string|max:100')]
    public $country = '';
    
    #[Rule('required|string|max:100')]
    public $emergency_contact_name = '';
    
    #[Rule('required|string|max:20')]
    public $emergency_contact_phone = '';
    
    #[Rule('required|string|max:50')]
    public $emergency_contact_relation = '';

    // Step 3: Employment Details
    #[Rule('required|string|max:20|unique:employees,employee_id')]
    public $employee_id = '';
    
    #[Rule('required|string|max:100')]
    public $department = '';
    
    #[Rule('required|string|max:100')]
    public $position = '';
    
    #[Rule('required|date')]
    public $hire_date = '';
    
    #[Rule('required|in:full-time,part-time,contract,intern')]
    public $employment_type = '';
    
    #[Rule('required|in:active,inactive,terminated,on-leave')]
    public $employment_status = 'active';
    
    #[Rule('required|numeric|min:0')]
    public $salary = '';
    
    #[Rule('nullable|string|max:100')]
    public $manager = '';
    
    #[Rule('required|string|max:100')]
    public $work_location = '';
    
    #[Rule('required')]
    public $work_start_time = '';
    
    #[Rule('required')]
    public $work_end_time = '';
    
    public $work_days = [];

    // Step 4: Additional Information
    #[Rule('required|string|max:100')]
    public $highest_education = '';
    
    #[Rule('nullable|string|max:150')]
    public $university = '';
    
    #[Rule('nullable|integer|min:1950|max:2024')]
    public $graduation_year = '';
    
    #[Rule('nullable|string|max:1000')]
    public $skills = '';
    
    #[Rule('nullable|string|max:1000')]
    public $certifications = '';
    
    #[Rule('required|integer|min:0|max:50')]
    public $experience_years = 0;
    
    #[Rule('nullable|image|max:2048')]
    public $profile_photo = null;
    
    #[Rule('nullable|mimes:pdf,doc,docx|max:5120')]
    public $resume = null;
    
    public $languages = [];
    
    #[Rule('nullable|string|max:500')]
    public $hobbies = '';
    
    public $has_driving_license = false;
    
    #[Rule('nullable|string|max:50')]
    public $driving_license_number = '';
    
    public $willing_to_relocate = false;
    public $willing_to_travel = false;
    
    #[Rule('required|integer|min:0|max:365')]
    public $notice_period_days = 30;
    
    #[Rule('nullable|string|max:1000')]
    public $notes = '';

    public $showSuccess = false;
    public $successMessage = '';

    protected $messages = [
        'first_name.required' => 'First name is required.',
        'last_name.required' => 'Last name is required.',
        'email.required' => 'Email is required.',
        'email.unique' => 'This email is already registered.',
        'date_of_birth.required' => 'Date of birth is required.',
        'date_of_birth.before' => 'Date of birth must be before today.',
        'employee_id.required' => 'Employee ID is required.',
        'employee_id.unique' => 'This Employee ID is already taken.',
        'hire_date.required' => 'Hire date is required.',
        'salary.required' => 'Salary is required.',
        'profile_photo.image' => 'Profile photo must be an image.',
        'profile_photo.max' => 'Profile photo must not exceed 2MB.',
        'resume.mimes' => 'Resume must be a PDF or Word document.',
        'resume.max' => 'Resume must not exceed 5MB.',
    ];

    public function mount()
    {
        $this->employee_id = 'EMP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $this->hire_date = now()->format('Y-m-d');
        $this->work_start_time = '09:00';
        $this->work_end_time = '17:00';
        $this->work_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $this->languages = ['english'];
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            // Validate all previous steps
            for ($i = 1; $i < $step; $i++) {
                try {
                    $this->validateStep($i);
                } catch (\Exception $e) {
                    return; // Don't allow jumping if previous steps are invalid
                }
            }
            $this->currentStep = $step;
        }
    }

    private function validateCurrentStep()
    {
        $this->validateStep($this->currentStep);
    }

    private function validateStep($step)
    {
        switch ($step) {
            case 1:
                $this->validate([
                    'first_name' => 'required|string|min:2|max:100',
                    'last_name' => 'required|string|min:2|max:100',
                    'email' => 'required|email|max:150|unique:employees,email',
                    'phone' => 'nullable|string|max:20',
                    'date_of_birth' => 'required|date|before_or_equal:today',
                    'gender' => 'required|in:male,female,other',
                    'marital_status' => 'required|in:single,married,divorced,widowed',
                    'nationality' => 'required|string|max:100',
                ]);
                break;
            case 2:
                $this->validate([
                    'address' => 'required|string|max:500',
                    'city' => 'required|string|max:100',
                    'state' => 'required|string|max:100',
                    'postal_code' => 'required|string|max:20',
                    'country' => 'required|string|max:100',
                    'emergency_contact_name' => 'required|string|max:100',
                    'emergency_contact_phone' => 'required|string|max:20',
                    'emergency_contact_relation' => 'required|string|max:50',
                ]);
                break;
            case 3:
                $this->validate([
                    'employee_id' => 'required|string|max:20|unique:employees,employee_id',
                    'department' => 'required|string|max:100',
                    'position' => 'required|string|max:100',
                    'hire_date' => 'required|date',
                    'employment_type' => 'required|in:full-time,part-time,contract,intern',
                    'employment_status' => 'required|in:active,inactive,terminated,on-leave',
                    'salary' => 'required|numeric|min:0',
                    'work_location' => 'required|string|max:100',
                    'work_start_time' => 'required',
                    'work_end_time' => 'required',
                ]);
                break;
            case 4:
                $this->validate([
                    'highest_education' => 'required|string|max:100',
                    'graduation_year' => 'nullable|integer|min:1950|max:2024',
                    'experience_years' => 'required|integer|min:0|max:50',
                    'profile_photo' => 'nullable|image|max:2048',
                    'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
                    'notice_period_days' => 'required|integer|min:0|max:365',
                ]);
                break;
        }
    }

    public function submit()
    {
        // Validate all steps
        for ($i = 1; $i <= $this->totalSteps; $i++) {
            $this->validateStep($i);
        }

        try {
            // Prepare data array with proper null handling
            $data = [
                'first_name' => trim($this->first_name),
                'last_name' => trim($this->last_name),
                'email' => trim($this->email),
                'phone' => !empty(trim($this->phone)) ? trim($this->phone) : null,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'nationality' => trim($this->nationality),
                'address' => trim($this->address),
                'city' => trim($this->city),
                'state' => trim($this->state),
                'postal_code' => trim($this->postal_code),
                'country' => trim($this->country),
                'emergency_contact_name' => trim($this->emergency_contact_name),
                'emergency_contact_phone' => trim($this->emergency_contact_phone),
                'emergency_contact_relation' => trim($this->emergency_contact_relation),
                'employee_id' => trim($this->employee_id),
                'department' => trim($this->department),
                'position' => trim($this->position),
                'hire_date' => $this->hire_date,
                'employment_type' => $this->employment_type,
                'employment_status' => $this->employment_status,
                'salary' => floatval($this->salary),
                'manager' => !empty(trim($this->manager)) ? trim($this->manager) : null,
                'work_location' => trim($this->work_location),
                'work_start_time' => $this->work_start_time,
                'work_end_time' => $this->work_end_time,
                'work_days' => is_array($this->work_days) ? $this->work_days : [],
                'highest_education' => trim($this->highest_education),
                'university' => !empty(trim($this->university)) ? trim($this->university) : null,
                'graduation_year' => !empty($this->graduation_year) ? intval($this->graduation_year) : null,
                'skills' => !empty(trim($this->skills)) ? trim($this->skills) : null,
                'certifications' => !empty(trim($this->certifications)) ? trim($this->certifications) : null,
                'experience_years' => intval($this->experience_years),
                'languages' => is_array($this->languages) ? $this->languages : [],
                'hobbies' => !empty(trim($this->hobbies)) ? trim($this->hobbies) : null,
                'has_driving_license' => (bool)$this->has_driving_license,
                'driving_license_number' => !empty(trim($this->driving_license_number)) ? trim($this->driving_license_number) : null,
                'willing_to_relocate' => (bool)$this->willing_to_relocate,
                'willing_to_travel' => (bool)$this->willing_to_travel,
                'notice_period_days' => intval($this->notice_period_days),
                'notes' => !empty(trim($this->notes)) ? trim($this->notes) : null,
                'is_active' => true,
            ];

            // Handle file uploads
            if ($this->profile_photo) {
                $data['profile_photo'] = $this->profile_photo->store('employee-photos', 'public');
            }

            if ($this->resume) {
                $data['resume'] = $this->resume->store('employee-resumes', 'public');
            }

            $employee = Employee::create($data);

            $this->showSuccess = true;
            $this->successMessage = "Employee registration completed successfully! Employee ID: {$employee->employee_id}";
            
            $this->dispatch('employee-registered', ['employee' => $employee]);

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error during employee creation: ' . $e->getMessage());
            $this->addError('general', 'Database error: Please make sure the employees table exists and all required fields are properly configured.');
        } catch (\Exception $e) {
            \Log::error('General error during employee creation: ' . $e->getMessage());
            $this->addError('general', 'Error details: ' . $e->getMessage() . ' Please check the logs for more information.');
        }
    }

    public function resetForm()
    {
        $this->currentStep = 1;
        $this->reset();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.employee-registration')
            ->layout('layouts.app')
            ->title('Employee Registration');
    }
}