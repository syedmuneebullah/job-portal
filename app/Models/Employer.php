<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'company_name',
        'company_logo',
        'company_description',
        'website',
        'industry',
        'company_size',
        'founded_year',
        'headquarters',
        'linkedin_url',
        'twitter_url',
        'verification_status',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'founded_year' => 'integer',
    ];

    // ===== RELATIONSHIPS =====
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    // Alias for jobPosts (for backward compatibility and cleaner code)
    public function jobs()
    {
        return $this->hasMany(JobPost::class);
    }

    public function activeJobs()
    {
        return $this->jobPosts()->where('status', 'published')
            ->where(function($query) {
                $query->whereNull('closing_at')
                    ->orWhere('closing_at', '>', now());
            });
    }

    public function applications()
    {
        return $this->hasManyThrough(
            Application::class,
            JobPost::class,
            'employer_id', // Foreign key on job_posts table
            'job_post_id', // Foreign key on applications table
            'id', // Local key on employers table
            'id' // Local key on job_posts table
        );
    }

    public function teamMembers()
    {
        return $this->hasMany(EmployerTeamMember::class);
    }

    public function recruiters()
    {
        return $this->hasManyThrough(
            User::class,
            Recruiter::class,
            'employer_id',
            'id',
            'id',
            'user_id'
        );
    }

    // ===== SCOPES =====
    
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('company_name', 'LIKE', "%{$search}%")
              ->orWhere('industry', 'LIKE', "%{$search}%")
              ->orWhere('headquarters', 'LIKE', "%{$search}%")
              ->orWhereHas('user', function($u) use ($search) {
                  $u->where('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
              });
        });
    }

    // ===== ACCESSORS =====
    
    public function getIsVerifiedAttribute()
    {
        return $this->verification_status === 'verified';
    }

    public function getLogoUrlAttribute()
    {
        if ($this->company_logo) {
            return asset('storage/' . $this->company_logo);
        }
        return null;
    }

    public function getCompanyInitialsAttribute()
    {
        $words = explode(' ', $this->company_name);
        $initials = '';
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper($word[0]);
            }
            if (strlen($initials) >= 2) break;
        }
        return $initials ?: substr($this->company_name, 0, 2);
    }

    public function getVerificationBadgeAttribute()
    {
        return match($this->verification_status) {
            'verified' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Verified
            </span>',
            'pending' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                Pending
            </span>',
            'rejected' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Rejected
            </span>',
            default => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Unknown</span>'
        };
    }

    // ===== HELPER METHODS =====
    
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    public function getTotalJobsCount()
    {
        return $this->jobPosts()->count();
    }

    public function getActiveJobsCount()
    {
        return $this->activeJobs()->count();
    }

    public function getTotalApplicationsCount()
    {
        return $this->applications()->count();
    }

    public function getPendingApplicationsCount()
    {
        return $this->applications()->where('status', 'pending')->count();
    }

    public function getHiredCount()
    {
        return $this->applications()->where('status', 'hired')->count();
    }

    // ===== STATIC METHODS =====
    
    public static function getVerificationStats()
    {
        return [
            'verified' => self::verified()->count(),
            'pending' => self::pending()->count(),
            'rejected' => self::rejected()->count(),
            'total' => self::count(),
        ];
    }

    public static function getIndustryStats()
    {
        return self::select('industry')
            ->whereNotNull('industry')
            ->withCount('jobPosts')
            ->get()
            ->groupBy('industry')
            ->map(function($group) {
                return [
                    'total_companies' => $group->count(),
                    'total_jobs' => $group->sum('job_posts_count'),
                ];
            });
    }
}