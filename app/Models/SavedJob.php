<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_post_id',
        'notes',
        'status',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_SAVED = 'saved';
    const STATUS_APPLIED = 'applied';
    const STATUS_ARCHIVED = 'archived';

    // ===== RELATIONSHIPS =====
    
    /**
     * Get the user that saved the job.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job post that was saved.
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    // ===== SCOPES =====
    
    /**
     * Scope to get saved jobs only.
     */
    public function scopeSaved($query)
    {
        return $query->where('status', self::STATUS_SAVED);
    }

    /**
     * Scope to get applied jobs only.
     */
    public function scopeApplied($query)
    {
        return $query->where('status', self::STATUS_APPLIED);
    }

    /**
     * Scope to get archived jobs only.
     */
    public function scopeArchived($query)
    {
        return $query->where('status', self::STATUS_ARCHIVED);
    }

    /**
     * Scope to get jobs for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ===== ACCESSORS =====
    
    /**
     * Check if the job is saved.
     */
    public function getIsSavedAttribute()
    {
        return $this->status === self::STATUS_SAVED;
    }

    /**
     * Check if the job is applied.
     */
    public function getIsAppliedAttribute()
    {
        return $this->status === self::STATUS_APPLIED;
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get status color for UI.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_SAVED => 'blue',
            self::STATUS_APPLIED => 'emerald',
            self::STATUS_ARCHIVED => 'gray',
            default => 'gray',
        };
    }

    // ===== MUTATORS =====
    
    /**
     * Set status and update applied_at if status is applied.
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        
        if ($value === self::STATUS_APPLIED && !$this->applied_at) {
            $this->attributes['applied_at'] = now();
        }
    }
}