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

    // Relationships
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

    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function recruiterJobs()
    {
        return $this->hasMany(JobPost::class, 'recruiter_id');
    }

    public function teamMembers()
    {
        return $this->hasMany(EmployerTeamMember::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

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

    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    public function resumeParserJobs()
    {
        return $this->hasMany(ResumeParserJob::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function approvedRecruiters()
    {
        return $this->hasMany(Recruiter::class, 'approved_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Scopes
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
}
