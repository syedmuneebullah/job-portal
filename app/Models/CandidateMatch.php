<?php
// app/Models/CandidateMatch.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateMatch extends Model
{
    protected $fillable = [
        'job_post_id', 'application_id', 'resume_parse_id',
        'overall_score', 'skills_match_score', 'experience_match_score',
        'education_match_score', 'certifications_match_score',
        'matched_skills', 'missing_skills', 'matching_experience',
        'matching_education', 'match_details', 'rank', 'tier',
        'is_shortlisted', 'is_recommended', 'is_viewed', 'matched_at'
    ];

    protected $casts = [
        'matched_skills' => 'array',
        'missing_skills' => 'array',
        'matching_experience' => 'array',
        'matching_education' => 'array',
        'match_details' => 'array',
        'overall_score' => 'float',
        'skills_match_score' => 'float',
        'experience_match_score' => 'float',
        'education_match_score' => 'float',
        'certifications_match_score' => 'float',
        'is_shortlisted' => 'boolean',
        'is_recommended' => 'boolean',
        'is_viewed' => 'boolean',
        'matched_at' => 'datetime',
    ];

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function resumeParse(): BelongsTo
    {
        return $this->belongsTo(ResumeParse::class);
    }

    public function aiRecommendation()
    {
        return $this->hasOne(AiRecommendation::class);
    }

    // Scopes
    public function scopeTopCandidates($query, $limit = 10)
    {
        return $query->orderBy('overall_score', 'desc')->limit($limit);
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    public function scopeShortlisted($query)
    {
        return $query->where('is_shortlisted', true);
    }
}