<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'institute_name',
        'description',
        'education_title',
        'start_date',
        'end_date',
        'on_going',
        'country',
        'state',
        'city',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== RELATIONSHIPS =====
    
    /**
     * Get the user that owns the education record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ===== SCOPES =====
    
    /**
     * Scope a query to only include ongoing education.
     */
    public function scopeOngoing($query)
    {
        return $query->where('on_going', 'yes');
    }

    /**
     * Scope a query to only include completed education.
     */
    public function scopeCompleted($query)
    {
        return $query->where('on_going', 'no');
    }

    /**
     * Scope a query to order by start date (latest first).
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('start_date', 'desc');
    }

    // ===== ACCESSORS =====
    
    /**
     * Get the formatted duration of education.
     */
    public function getDurationAttribute()
    {
        if ($this->on_going === 'yes') {
            return $this->start_date . ' - Present';
        }
        
        if ($this->start_date && $this->end_date) {
            return $this->start_date . ' - ' . $this->end_date;
        }
        
        return 'N/A';
    }

    public function getPeriodAttribute()
    {
        $start = $this->start_date ? date('M Y', strtotime($this->start_date)) : 'N/A';
        $end = $this->on_going === 'yes' ? 'Present' : ($this->end_date ? date('M Y', strtotime($this->end_date)) : 'N/A');
        
        return $start . ' - ' . $end;
    }

    /**
     * Get the education title with institute name.
     */
    public function getFullTitleAttribute()
    {
        $title = $this->education_title ?? 'Education';
        
        if ($this->institute_name) {
            $title .= ' at ' . $this->institute_name;
        }
        
        return $title;
    }

    /**
     * Get the location (city, state, country) as a string.
     */
    public function getLocationAttribute()
    {
        $location = [];
        
        if ($this->city) {
            $location[] = $this->city;
        }
        if ($this->state) {
            $location[] = $this->state;
        }
        if ($this->country) {
            $location[] = $this->country;
        }
        
        return implode(', ', $location);
    }

    /**
     * Check if the education is ongoing.
     */
    public function getIsOngoingAttribute()
    {
        return $this->on_going === 'yes';
    }

    // ===== MUTATORS =====
    
    /**
     * Set the on_going attribute.
     */
    public function setOnGoingAttribute($value)
    {
        $this->attributes['on_going'] = $value === 'yes' || $value === true ? 'yes' : 'no';
    }
}