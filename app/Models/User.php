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

    // ===== RESUME RELATIONSHIP =====
    /**
     * Get the resume for the user (applicant).
     */
    public function resume()
    {
        return $this->hasOne(Resume::class, 'user_id');
    }

    /**
     * Get the resumes for the user (if multiple resumes are allowed).
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class, 'user_id');
    }

    /**
     * Get the active/primary resume for the user.
     */
    public function activeResume()
    {
        return $this->hasOne(Resume::class, 'user_id')->where('is_active', true);
    }

    /**
     * Get the default/primary resume for the user.
     */
    public function primaryResume()
    {
        return $this->hasOne(Resume::class, 'user_id')->where('is_primary', true);
    }

    // ===== JOB RELATIONSHIPS =====
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function recruiterJobs()
    {
        return $this->hasMany(JobPost::class, 'recruiter_id');
    }

    public function jobs()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function getAllJobs()
    {
        return JobPost::where('employer_id', $this->id)
            ->orWhere('recruiter_id', $this->id);
    }

    // ===== APPLICATION RELATIONSHIPS =====
    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function employerApplications()
    {
        return $this->hasMany(Application::class, 'employer_id');
    }

    // ===== TEAM RELATIONSHIPS =====
    public function teamMembers()
    {
        return $this->hasMany(EmployerTeamMember::class);
    }

    // ===== MESSAGE RELATIONSHIPS =====
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // ===== INTERVIEW RELATIONSHIPS =====
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

    // ===== SUBSCRIPTION & PAYMENT =====
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

    // ===== NOTIFICATION & SETTINGS =====
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

    // ===== JOB SEEKER FEATURES =====
    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    // ===== RESUME & REPORTS =====
    public function resumeParserJobs()
    {
        return $this->hasMany(ResumeParserJob::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // ===== ADMIN/APPROVAL =====
    public function approvedRecruiters()
    {
        return $this->hasMany(Recruiter::class, 'approved_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // ===== EDUCATION, EXPERIENCE, CERTIFICATES =====
    public function educations()
    {
        return $this->hasMany(ApplicantEducation::class)->orderBy('start_date', 'desc');
    }

    public function experiences()
    {
        return $this->hasMany(ApplicantExperience::class)->orderBy('start_date', 'desc');
    }

    public function certificates()
    {
        return $this->hasMany(ApplicantCertificate::class)->orderBy('start_date', 'desc');
    }

    public function latestEducation()
    {
        return $this->hasOne(ApplicantEducation::class)->latest('start_date');
    }

    public function latestExperience()
    {
        return $this->hasOne(ApplicantExperience::class)->latest('start_date');
    }

    public function latestCertificate()
    {
        return $this->hasOne(ApplicantCertificate::class)->latest('start_date');
    }

    // ===== SAVED JOBS =====
    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    public function savedJobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'saved_jobs', 'user_id', 'job_post_id')
                    ->withPivot('notes', 'status', 'applied_at')
                    ->withTimestamps();
    }

    public function hasSavedJob($jobPostId)
    {
        return $this->savedJobs()->where('job_post_id', $jobPostId)->exists();
    }

    public function getSavedJobsCountAttribute()
    {
        return $this->savedJobs()->saved()->count();
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

    /**
     * Get the resume file URL.
     */
    public function getResumeUrlAttribute()
    {
        if ($this->resume && $this->resume->file_path) {
            return asset('storage/' . $this->resume->file_path);
        }
        return null;
    }

    /**
     * Check if the user has a resume uploaded.
     */
    public function getHasResumeAttribute()
    {
        return $this->resume()->exists();
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

    public function scopeHasResume($query)
    {
        return $query->whereHas('resume');
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
}
