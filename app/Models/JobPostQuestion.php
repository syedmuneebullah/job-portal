<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPostQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id',
        'question',
        'type',
        'required',
        'options',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }
}
