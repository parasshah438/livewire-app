<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name', 
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'marital_status',
        'nationality',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'employee_id',
        'department',
        'position',
        'hire_date',
        'employment_type',
        'employment_status',
        'salary',
        'manager',
        'work_location',
        'work_start_time',
        'work_end_time',
        'work_days',
        'highest_education',
        'university',
        'graduation_year',
        'skills',
        'certifications',
        'experience_years',
        'profile_photo',
        'resume',
        'languages',
        'hobbies',
        'has_driving_license',
        'driving_license_number',
        'willing_to_relocate',
        'willing_to_travel',
        'notice_period_days',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'work_start_time' => 'datetime:H:i',
        'work_end_time' => 'datetime:H:i',
        'work_days' => 'array',
        'languages' => 'array',
        'salary' => 'decimal:2',
        'has_driving_license' => 'boolean',
        'willing_to_relocate' => 'boolean',
        'willing_to_travel' => 'boolean',
        'is_active' => 'boolean',
        'graduation_year' => 'integer',
        'experience_years' => 'integer',
        'notice_period_days' => 'integer'
    ];

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByEmploymentType($query, $type)
    {
        return $query->where('employment_type', $type);
    }
}