<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'user_type',
        'status',
        'phone',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ===== RELATIONSHIPS =====
    
    // Profile relationships
    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    public function recruiter()
    {
        return $this->hasOne(Recruiter::class);
    }

    public function applicantProfile()
    {
        return $this->hasOne(ApplicantProfile::class);
    }

    // Job relationships
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function recruiterJobs()
    {
        return $this->hasMany(JobPost::class, 'recruiter_id');
    }

    // Alias for jobPosts (for backward compatibility)
    public function jobs()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    // Get all jobs (employer + recruiter)
    public function getAllJobs()
    {
        return JobPost::where('employer_id', $this->id)
            ->orWhere('recruiter_id', $this->id);
    }

    // Application relationships
    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function employerApplications()
    {
        return $this->hasMany(Application::class, 'employer_id');
    }

    // Team relationships
    public function teamMembers()
    {
        return $this->hasMany(EmployerTeamMember::class);
    }

    // Message relationships
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Interview relationships
    public function interviews()
    {
        return $this->hasMany(Interview::class, 'employer_id');
    }

    public function applicantInterviews()
    {
        return $this->hasMany(Interview::class, 'applicant_id');
    }

    public function recruiterInterviews()
    {
        return $this->hasMany(Interview::class, 'recruiter_id');
    }

    // Subscription & Payment
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Notification & Settings
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function webhooks()
    {
        return $this->hasMany(Webhook::class);
    }

    public function integrationSettings()
    {
        return $this->hasMany(IntegrationSetting::class);
    }

    // Job seeker features
    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    // Resume & Reports
    public function resumeParserJobs()
    {
        return $this->hasMany(ResumeParserJob::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Admin/Approval
    public function approvedRecruiters()
    {
        return $this->hasMany(Recruiter::class, 'approved_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // ===== ACCESSORS =====
    
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1)) . strtoupper(substr($this->last_name, 0, 1));
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return null;
    }

    // ===== SCOPES =====
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeEmployers($query)
    {
        return $query->where('user_type', 'employer');
    }

    public function scopeRecruiters($query)
    {
        return $query->where('user_type', 'recruiter');
    }

    public function scopeApplicants($query)
    {
        return $query->where('user_type', 'applicant');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    // ===== HELPER METHODS =====
    
    public function isEmployer()
    {
        return $this->user_type === 'employer';
    }

    public function isRecruiter()
    {
        return $this->user_type === 'recruiter';
    }

    public function isApplicant()
    {
        return $this->user_type === 'applicant';
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    public function isVerified()
    {
        return !is_null($this->email_verified_at);
    }

     /**
     * Get the education records for the user.
     */
    public function educations()
    {
        return $this->hasMany(ApplicantEducation::class)->orderBy('start_date', 'desc');
    }

    /**
     * Get the experience records for the user.
     */
    public function experiences()
    {
        return $this->hasMany(ApplicantExperience::class)->orderBy('start_date', 'desc');
    }

    /**
     * Get the certificate records for the user.
     */
    public function certificates()
    {
        return $this->hasMany(ApplicantCertificate::class)->orderBy('start_date', 'desc');
    }

    /**
     * Get the latest education record.
     */
    public function latestEducation()
    {
        return $this->hasOne(ApplicantEducation::class)->latest('start_date');
    }

    /**
     * Get the latest experience record.
     */
    public function latestExperience()
    {
        return $this->hasOne(ApplicantExperience::class)->latest('start_date');
    }

    /**
     * Get the latest certificate record.
     */
    public function latestCertificate()
    {
        return $this->hasOne(ApplicantCertificate::class)->latest('start_date');
    }

    /**
     * Get the saved jobs for the user.
     */
    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    /**
     * Get the saved job posts directly.
     */
    public function savedJobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'saved_jobs', 'user_id', 'job_post_id')
                    ->withPivot('notes', 'status', 'applied_at')
                    ->withTimestamps();
    }

    /**
     * Check if user has saved a specific job.
     */
    public function hasSavedJob($jobPostId)
    {
        return $this->savedJobs()->where('job_post_id', $jobPostId)->exists();
    }

    /**
     * Get user's saved jobs count.
     */
    public function getSavedJobsCountAttribute()
    {
        return $this->savedJobs()->saved()->count();
    }
}