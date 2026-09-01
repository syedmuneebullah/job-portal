<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'current_job_title',
        'current_company',
        'skills',
        'languages',
        'interests',
        'resume_path',
        'portfolio_url',
        'github_url',
        'linkedin_url',
        'website',
        'education',
        'experience',
        'certifications',
        'publications',
        'preferred_work_type',
        'preferred_locations',
        'salary_expectation_min',
        'salary_expectation_max',
        'currency',
        'is_visible',
        'last_active_at',
    ];

    protected $casts = [
        'skills' => 'array',
        'languages' => 'array',
        'interests' => 'array',
        'education' => 'array',
        'experience' => 'array',
        'certifications' => 'array',
        'publications' => 'array',
        'preferred_locations' => 'array',
        'is_visible' => 'boolean',
        'last_active_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function resumeParserJobs()
    {
        return $this->hasMany(ResumeParserJob::class, 'user_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : null;
    }

    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeWithSkills($query, $skills)
    {
        if (is_array($skills)) {
            foreach ($skills as $skill) {
                $query->whereJsonContains('skills', $skill);
            }
        }
        return $query;
    }
}
