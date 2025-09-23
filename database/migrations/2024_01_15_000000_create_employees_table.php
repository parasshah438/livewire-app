<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            
            // Personal Information
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('nationality', 100);
            
            // Contact Information
            $table->text('address');
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('postal_code', 20);
            $table->string('country', 100);
            $table->string('emergency_contact_name', 100);
            $table->string('emergency_contact_phone', 20);
            $table->string('emergency_contact_relation', 50);
            
            // Employment Details
            $table->string('employee_id', 20)->unique();
            $table->string('department', 100);
            $table->string('position', 100);
            $table->date('hire_date');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'intern']);
            $table->enum('employment_status', ['active', 'inactive', 'terminated', 'on-leave']);
            $table->decimal('salary', 10, 2);
            $table->string('manager', 100)->nullable();
            $table->string('work_location', 100);
            $table->time('work_start_time');
            $table->time('work_end_time');
            $table->json('work_days'); // Store array of working days
            
            // Education & Skills
            $table->string('highest_education', 100);
            $table->string('university', 150)->nullable();
            $table->year('graduation_year')->nullable();
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->integer('experience_years')->default(0);
            
            // Additional Information
            $table->string('profile_photo')->nullable();
            $table->text('resume')->nullable();
            $table->json('languages')->nullable(); // Store array of languages
            $table->text('hobbies')->nullable();
            $table->boolean('has_driving_license')->default(false);
            $table->string('driving_license_number', 50)->nullable();
            $table->boolean('willing_to_relocate')->default(false);
            $table->boolean('willing_to_travel')->default(false);
            $table->integer('notice_period_days')->default(30);
            
            // System fields
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};