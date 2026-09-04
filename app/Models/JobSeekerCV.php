<?php
// app/Models/JobSeekerCV.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class JobSeekerCV extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cv_template_id',
        'content',
        'customizations',
        'cv_template_color_id',
        'selected_sections',
        'title',
        'file_path',
        'status',
        'version',
        'last_generated_at',
    ];

    protected $casts = [
        'content' => 'array',
        'customizations' => 'array',
        'selected_sections' => 'array',
        'last_generated_at' => 'datetime',
    ];

    /**
     * Get the user who owns this CV
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this CV
     */
    public function template()
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }

    /**
     * Get the color scheme used for this CV
     */
    public function color()
    {
        return $this->belongsTo(CvTemplateColor::class, 'cv_template_color_id');
    }

    /**
     * Get the CV file URL
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Increment version number
     */
    public function incrementVersion()
    {
        $this->increment('version');
        $this->save();
    }
}