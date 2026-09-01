<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'recruiter_type',
        'agency_name',
        'agency_website',
        'specialization',
        'years_experience',
        'certifications',
        'approval_status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'recruiter_id');
    }

    public function referrals()
    {
        return $this->hasMany(RecruiterReferral::class, 'recruiter_id');
    }

    public function campaigns()
    {
        return $this->hasMany(RecruiterCampaign::class, 'recruiter_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    // Accessor
    public function getIsApprovedAttribute()
    {
        return $this->approval_status === 'approved';
    }
}
