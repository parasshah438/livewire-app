<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Rule;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactUs extends Component
{
    #[Rule('required|min:2|max:100|regex:/^[\pL\s\-\.\']+$/u')]
    public string $name = '';
    
    #[Rule('required|email|max:150')]
    public string $email = '';
    
    #[Rule('required|min:5|max:200')]
    public string $subject = '';
    
    #[Rule('required|min:10|max:2000')]
    public string $message = '';
    
    #[Rule('nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/')]
    public string $phone = '';
    
    public bool $showSuccess = false;
    public string $successMessage = '';
    public bool $isSubmitting = false;
    
    protected array $messages = [
        'name.required' => 'Full name is required.',
        'name.min' => 'Name must be at least 2 characters.',
        'name.max' => 'Name cannot exceed 100 characters.',
        'name.regex' => 'Name can only contain letters, spaces, hyphens, dots and apostrophes.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email cannot exceed 150 characters.',
        'subject.required' => 'Subject is required.',
        'subject.min' => 'Subject must be at least 5 characters.',
        'subject.max' => 'Subject cannot exceed 200 characters.',
        'message.required' => 'Message is required.',
        'message.min' => 'Message must be at least 10 characters.',
        'message.max' => 'Message cannot exceed 2000 characters.',
        'phone.max' => 'Phone number cannot exceed 20 characters.',
        'phone.regex' => 'Please enter a valid phone number.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->showSuccess = false;
    }

    public function submit()
    {
        $this->validate();
        
        try {
            // Save to database
            $contactMessage = ContactMessage::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'subject' => $this->subject,
                'message' => $this->message,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Optional: Send email notification (uncomment if you have mail configured)
            // try {
            //     Mail::send('emails.contact', [
            //         'name' => $this->name,
            //         'email' => $this->email,
            //         'subject' => $this->subject,
            //         'message' => $this->message,
            //         'phone' => $this->phone,
            //     ], function($mail) {
            //         $mail->to('admin@example.com')
            //              ->subject('New Contact Form: ' . $this->subject)
            //              ->replyTo($this->email, $this->name);
            //     });
            // } catch (\Exception $mailException) {
            //     Log::error('Contact form email failed: ' . $mailException->getMessage());
            //     // Don't fail the whole process if email fails
            // }
            
            // Clear all form fields
            $this->resetForm();
            
            // Show success message
            $this->showSuccess = true;
            $this->successMessage = "Thank you, your message has been sent successfully! We'll get back to you within 24 hours.";
            
            // Log successful submission
            Log::info('Contact form submitted successfully', [
                'id' => $contactMessage->id,
                'email' => $contactMessage->email,
                'subject' => $contactMessage->subject
            ]);

            // Dispatch event for frontend handling
            $this->dispatch('form-submitted');
            
        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            $this->addError('general', 'Sorry, there was an error processing your message. Please try again or contact us directly.');
        }
    }

    public function resetForm()
    {
        // Reset all form fields to empty strings
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->subject = '';
        $this->message = '';
        
        // Clear all validation errors
        $this->resetErrorBag();
        
        // Reset validation state
        $this->resetValidation();
    }

    public function hideSuccess()
    {
        $this->showSuccess = false;
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.contact-us')
            ->layout('layouts.app')
            ->title('Contact Us');
    }
}