<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserProfile extends Component
{
    use WithFileUploads;

    // User Info Properties
    public $name;
    public $email;
    public $profile_photo;
    
    // Password Change Properties
    public $current_password;
    public $password;
    public $password_confirmation;
    
    // UI State
    public $showPasswordForm = false;
    public $profileUpdated = false;
    public $passwordChanged = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'profile_photo' => 'nullable|image|max:1024', // 1MB Max
    ];

    protected $passwordRules = [
        'current_password' => 'required',
        'password' => 'required|confirmed|min:8|max:255',
        'password_confirmation' => 'required',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $user = Auth::user();
        
        // Update email validation to exclude current user
        $this->rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
        
        $this->validate($this->rules);

        // Handle profile photo upload
        if ($this->profile_photo) {
            // Delete old profile photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            // Store new profile photo
            $photoPath = $this->profile_photo->store('profile-photos', 'public');
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo' => isset($photoPath) ? $photoPath : $user->profile_photo,
        ]);

        // Reset file input
        $this->profile_photo = null;
        $this->profileUpdated = true;
        
        // Reset success message after 3 seconds
        $this->dispatch('profile-updated');
        
        // Hide success message after 3 seconds
        $this->js('setTimeout(() => { $wire.set("profileUpdated", false) }, 3000)');
    }

    public function togglePasswordForm()
    {
        $this->showPasswordForm = !$this->showPasswordForm;
        $this->resetPasswordFields();
    }

    public function updatePassword()
    {
        $this->validate($this->passwordRules);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        // Check if new password is same as current password
        if (Hash::check($this->password, $user->password)) {
            $this->addError('password', 'The new password cannot be the same as your current password.');
            return;
        }

        // Update password
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->passwordChanged = true;
        $this->resetPasswordFields();
        $this->showPasswordForm = false;
        
        // Hide success message after 3 seconds
        $this->js('setTimeout(() => { $wire.set("passwordChanged", false) }, 3000)');
    }

    private function resetPasswordFields()
    {
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag(['current_password', 'password', 'password_confirmation']);
    }

    public function render()
    {
        return view('livewire.user-profile')
            ->layout('layouts.app-livewire');
    }
}
