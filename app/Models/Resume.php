<?php
// app/Models/Resume.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cv_template_id',
        'cv_template_color_id',
        'content',
        'customizations',
        'selected_sections',
        'title',
        'file_path',
        'original_name',
        'file_size',
        'mime_type',
        'status',
        'version',
        'last_generated_at',
        'is_active',
        'is_primary',
        'parsed_data',
        'parsed_at',
        'uploaded_at',
    ];

    protected $casts = [
        'content' => 'array',
        'customizations' => 'array',
        'selected_sections' => 'array',
        'parsed_data' => 'array',
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
        'parsed_at' => 'datetime',
        'uploaded_at' => 'datetime',
        'last_generated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ===== RELATIONSHIPS =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the template associated with this resume/CV
     */
    public function template()
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }

    /**
     * Get the color scheme associated with this resume/CV
     */
    public function color()
    {
        return $this->belongsTo(CvTemplateColor::class, 'cv_template_color_id');
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // ===== ACCESSORS =====

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getFormattedSizeAttribute()
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $i = 0;

        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    /**
     * Get the template name
     */
    public function getTemplateNameAttribute()
    {
        return $this->template ? $this->template->name : 'N/A';
    }

    /**
     * Get the status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft' => 'bg-gray-100 text-gray-700',
            'completed' => 'bg-emerald-100 text-emerald-700',
            'published' => 'bg-blue-100 text-blue-700',
        ];
        return $colors[$this->status] ?? 'bg-gray-100 text-gray-700';
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}