<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruiter_id',
        'job_post_id',
        'name',
        'type',
        'subject',
        'content',
        'target_criteria',
        'total_sent',
        'total_opened',
        'total_clicked',
        'total_converted',
        'status',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'target_criteria' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
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
}
