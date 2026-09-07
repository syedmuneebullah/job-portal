<?php
// app/Models/ResumeParse.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeParse extends Model
{
    protected $fillable = [
        'user_id', 'file_path', 'file_name', 'parsed_data',
        'skills', 'experience', 'education', 'certifications',
        'languages', 'summary', 'status', 'parsed_at'
    ];

    protected $casts = [
        'parsed_data' => 'array',
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'certifications' => 'array',
        'languages' => 'array',
        'parsed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function matches()
    {
        return $this->hasMany(CandidateMatch::class);
    }
}