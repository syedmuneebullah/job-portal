<?php
// app/Models/CvTemplateSection.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvTemplateSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'cv_template_id',
        'section_key',
        'section_name',
        'section_icon',
        'order',
        'is_enabled',
        'is_required',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_enabled' => 'boolean',
        'is_required' => 'boolean',
    ];

    /**
     * Get the template that owns this section
     */
    public function template()
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }
}