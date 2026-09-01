<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruiter_id',
        'job_post_id',
        'referral_code',
        'click_count',
        'signup_count',
        'application_count',
        'hire_count',
        'analytics',
        'expires_at',
    ];

    protected $casts = [
        'analytics' => 'array',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->referral_code = 'REF-' . strtoupper(\Str::random(8));
        });
    }
}
