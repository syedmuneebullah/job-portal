<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id',
        'applicant_id',
        'recruiter_id',
        'status',
        'ai_match_score',
        'match_details',
        'answers',
        'cover_letter',
        'is_referral',
        'referral_code',
        'reviewed_at',
        'shortlisted_at',
        'interview_at',
        'offered_at',
        'hired_at',
        'rejected_at',
        'scheduled_at',
        'rejection_reason',
        'screening_score',
        'screening_band',
        'screening_breakdown',
        'auto_knocked_out',
        'knockout_reason',
        'screened_at',
    ];

    protected $casts = [
        'match_details' => 'array',
        'answers' => 'array',
        'is_referral' => 'boolean',
        'ai_match_score' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'shortlisted_at' => 'datetime',
        'interview_at' => 'datetime',
        'offered_at' => 'datetime',
        'hired_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'screening_score'     => 'decimal:2',
        'screening_breakdown' => 'array',
        'auto_knocked_out'    => 'boolean',
        'screened_at'         => 'datetime',
    ];

    // Status constants
    const STATUS_APPLIED = 'applied';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_INTERVIEW = 'interview';
    const STATUS_OFFER = 'offer';
    const STATUS_HIRED = 'hired';
    const STATUS_REJECTED = 'rejected';
    const STATUS_WITHDRAWN = 'withdrawn';

    const STATUSES = [
        self::STATUS_APPLIED,
        self::STATUS_UNDER_REVIEW,
        self::STATUS_SHORTLISTED,
        self::STATUS_INTERVIEW,
        self::STATUS_OFFER,
        self::STATUS_HIRED,
        self::STATUS_REJECTED,
        self::STATUS_WITHDRAWN,
    ];

    const BAND_STRONG  = 'strong';
    const BAND_GOOD    = 'good';
    const BAND_AVERAGE = 'average';
    const BAND_WEAK    = 'weak';

    // Relationships
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function applicantProfile()
    {
        return $this->hasOneThrough(ApplicantProfile::class, User::class, 'id', 'user_id', 'applicant_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', self::STATUS_UNDER_REVIEW);
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', self::STATUS_SHORTLISTED);
    }

    public function scopeHired($query)
    {
        return $query->where('status', self::STATUS_HIRED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    public function getIsReviewedAttribute()
    {
        return !is_null($this->reviewed_at);
    }

    public function getIsShortlistedAttribute()
    {
        return !is_null($this->shortlisted_at);
    }

    // Mutators
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;

        // Update timestamp based on status
        switch ($value) {
            case self::STATUS_UNDER_REVIEW:
                $this->attributes['reviewed_at'] = now();
                break;
            case self::STATUS_SHORTLISTED:
                $this->attributes['shortlisted_at'] = now();
                break;
            case self::STATUS_INTERVIEW:
                $this->attributes['interview_at'] = now();
                break;
            case self::STATUS_OFFER:
                $this->attributes['offered_at'] = now();
                break;
            case self::STATUS_HIRED:
                $this->attributes['hired_at'] = now();
                break;
            case self::STATUS_REJECTED:
                $this->attributes['rejected_at'] = now();
                break;
        }
    }

    /**
     * Get the scheduled interview for this application
     */
    public function scheduleInterview()
    {
        return $this->hasOne(ScheduleInterview::class);
    }

    public function scopeStrongMatch($query)
    {
        return $query->where('screening_band', self::BAND_STRONG);
    }

    public function scopeGoodMatch($query)
    {
        return $query->where('screening_band', self::BAND_GOOD);
    }

    public function scopeNotKnockedOut($query)
    {
        return $query->where('auto_knocked_out', false);
    }

    public function scopeRanked($query)
    {
        return $query->orderByDesc('screening_score')->orderByDesc('created_at');
    }

    /**
     * Human-readable band label.
     */
    public function getScreeningBandLabelAttribute(): string
    {
        return match ($this->screening_band) {
            self::BAND_STRONG  => 'Strong Match',
            self::BAND_GOOD    => 'Good Match',
            self::BAND_AVERAGE => 'Average',
            self::BAND_WEAK    => 'Weak Match',
            default            => 'Not Screened',
        };
    }

    /**
     * Tailwind color classes for the band badge.
     */
    public function getScreeningBadgeClassesAttribute(): array
    {
        return match ($this->screening_band) {
            self::BAND_STRONG  => ['bg-emerald-500', 'text-white'],
            self::BAND_GOOD    => ['bg-blue-500',    'text-white'],
            self::BAND_AVERAGE => ['bg-amber-500',   'text-white'],
            self::BAND_WEAK    => ['bg-red-500',     'text-white'],
            default            => ['bg-gray-300',    'text-gray-700'],
        };
    }
}
