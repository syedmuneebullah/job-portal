<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'description',
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
     * Get the user that owns the experience record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ===== SCOPES =====
    
    /**
     * Scope a query to only include ongoing experience.
     */
    public function scopeOngoing($query)
    {
        return $query->where('on_going', 'yes');
    }

    /**
     * Scope a query to only include completed experience.
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

    /**
     * Scope a query to search by company or job title.
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('company_name', 'LIKE', "%{$search}%")
                  ->orWhere('job_title', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }

    // ===== ACCESSORS =====
    
    /**
     * Get the formatted duration of experience.
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

    /**
     * Get the job title with company name.
     */
    public function getFullTitleAttribute()
    {
        $title = $this->job_title ?? 'Position';
        
        if ($this->company_name) {
            $title .= ' at ' . $this->company_name;
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
     * Get the total years of experience (if completed).
     */
    public function getTotalYearsAttribute()
    {
        if ($this->on_going === 'no' && $this->start_date && $this->end_date) {
            $start = new \DateTime($this->start_date);
            $end = new \DateTime($this->end_date);
            $diff = $start->diff($end);
            
            return $diff->y + ($diff->m / 12);
        }
        
        return null;
    }

    /**
     * Get the total months of experience (if completed).
     */
    public function getTotalMonthsAttribute()
    {
        if ($this->on_going === 'no' && $this->start_date && $this->end_date) {
            $start = new \DateTime($this->start_date);
            $end = new \DateTime($this->end_date);
            $diff = $start->diff($end);
            
            return ($diff->y * 12) + $diff->m;
        }
        
        return null;
    }

    /**
     * Check if the experience is ongoing.
     */
    public function getIsOngoingAttribute()
    {
        return $this->on_going === 'yes';
    }

    /**
     * Get formatted experience period for display.
     */
    public function getPeriodAttribute()
    {
        $start = $this->start_date ? date('M Y', strtotime($this->start_date)) : 'N/A';
        $end = $this->on_going === 'yes' ? 'Present' : ($this->end_date ? date('M Y', strtotime($this->end_date)) : 'N/A');
        
        return $start . ' - ' . $end;
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