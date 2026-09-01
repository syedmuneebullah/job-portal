<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'employer_id',
        'recruiter_id',
        'applicant_id',
        'type',
        'scheduled_at',
        'duration_minutes',
        'location',
        'meeting_link',
        'notes',
        'participants',
        'status',
        'confirmed_at',
        'completed_at',
        'feedback',
    ];

    protected $casts = [
        'participants' => 'array',
        'scheduled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_RESCHEDULED = 'rescheduled';

    // Type constants
    const TYPE_PHONE = 'phone';
    const TYPE_VIDEO = 'video';
    const TYPE_ONSITE = 'onsite';
    const TYPE_TECHNICAL = 'technical';
    const TYPE_HR = 'hr';
    const TYPE_PANEL = 'panel';

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                     ->whereIn('status', [self::STATUS_SCHEDULED, self::STATUS_CONFIRMED]);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_at', now()->toDateString());
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->scheduled_at > now() &&
               in_array($this->status, [self::STATUS_SCHEDULED, self::STATUS_CONFIRMED]);
    }

    public function getIsPastAttribute()
    {
        return $this->scheduled_at < now() || $this->status === self::STATUS_COMPLETED;
    }
}
