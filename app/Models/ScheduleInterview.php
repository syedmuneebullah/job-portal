<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleInterview extends Model
{
    protected $fillable = [
        'application_id',
        'employer_id',
        'job_post_id',
        'interview_datetime',
        'duration',
        'timezone',
        'platform',
        'meeting_id',
        'meeting_link',
        'meeting_password',
        'meeting_join_url',
        'interviewer_name',
        'interviewer_email',
        'status',
        'notes',
        'feedback',
        'original_datetime',
        'reschedule_reason',
        'reminder_sent',
        'reminder_sent_at',
    ];

    protected $casts = [
        'interview_datetime' => 'datetime',
        'original_datetime' => 'datetime',
        'reminder_sent_at' => 'datetime',
    ];

    /**
     * Get the application associated with the interview
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the job post associated with the interview
     */
    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    /**
     * Get the employer associated with the interview
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * Get the applicant through the application
     */
    public function getApplicantAttribute()
    {
        return $this->application?->applicant;
    }
}