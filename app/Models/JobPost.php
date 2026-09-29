<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'benefits',
        'department',
        'location',
        'work_type',
        'employment_type',
        'experience_level',
        'salary_min',
        'salary_max',
        'currency',
        'required_skills',
        'preferred_skills',
        'education_requirement',
        'employer_id',
        'recruiter_id',
        'visibility',
        'status',
        'is_ai_generated',
        'published_at',
        'closing_at',
        'max_applications',
        'application_questions',
        'screening_enabled',
        'screening_weights',
        'knockout_rules',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'preferred_skills' => 'array',
        'application_questions' => 'array',
        'is_ai_generated' => 'boolean',
        'published_at' => 'datetime',
        'closing_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'screening_weights' => 'array',
        'knockout_rules'    => 'array',
        'screening_enabled' => 'boolean',
    ];

    // Relationships
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function questions()
    {
        return $this->hasMany(JobPostQuestion::class);
    }

    public function interviews()
    {
        return $this->hasManyThrough(Interview::class, Application::class);
    }

    public function recruiterCampaigns()
    {
        return $this->hasMany(RecruiterCampaign::class);
    }

    public function recruiterReferrals()
    {
        return $this->hasMany(RecruiterReferral::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'published')
                     ->where(function($q) {
                         $q->whereNull('closing_at')
                           ->orWhere('closing_at', '>', now());
                     });
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeByEmployer($query, $employerId)
    {
        return $query->where('employer_id', $employerId);
    }

    // Accessors
    public function getSalaryRangeAttribute()
    {
        if ($this->salary_min && $this->salary_max) {
            return $this->currency . ' ' . $this->salary_min . ' - ' . $this->salary_max;
        }
        return null;
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'published' &&
               (!$this->closing_at || $this->closing_at > now());
    }
    /**
     * Get the users who saved this job.
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs', 'job_post_id', 'user_id')
                    ->withPivot('notes', 'status', 'applied_at')
                    ->withTimestamps();
    }

    /**
     * Get the saved jobs record.
     */
    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class, 'job_post_id');
    }

    /**
     * Get the count of saves for this job.
     */
    public function getSavesCountAttribute()
    {
        return $this->savedJobs()->saved()->count();
    }

    /**
     * Check if a specific user saved this job.
     */
    public function isSavedByUser($userId)
    {
        return $this->savedJobs()->where('user_id', $userId)->exists();
    }

    /**
     * Default weights when no custom weights set.
     */
    public function getEffectiveWeightsAttribute(): array
    {
        return $this->screening_weights ?? [
            'skills'     => 35,
            'experience' => 25,
            'education'  => 15,
            'location'   => 10,
            'salary'     => 10,
            'answers'    => 5,
        ];
    }

    /**
     * Applications ordered by screening score (best first).
     */
    public function screenedApplications()
    {
        return $this->hasMany(Application::class)
            ->orderByDesc('screening_score')
            ->orderByDesc('created_at');
    }

    /**
     * Only strong/good matches.
     */
    public function topApplications($minScore = 60)
    {
        return $this->hasMany(Application::class)
            ->where('screening_score', '>=', $minScore)
            ->where('auto_knocked_out', false)
            ->orderByDesc('screening_score');
    }

    /**
 * Count of applications with strong/good screening scores.
 */
public function getStrongMatchCountAttribute(): int
{
    return $this->applications()
        ->where('auto_knocked_out', false)
        ->whereIn('screening_band', ['strong', 'good'])
        ->count();
}

/**
 * Count of auto-knocked-out applications.
 */
public function getKnockedOutCountAttribute(): int
{
    return $this->applications()
        ->where('auto_knocked_out', true)
        ->count();
}

/**
 * Has this job been screened at least once?
 */
public function getHasScreeningDataAttribute(): bool
{
    return $this->applications()
        ->whereNotNull('screened_at')
        ->exists();
}
}
