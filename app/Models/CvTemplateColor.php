<?php
// app/Models/CvTemplateColor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvTemplateColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'cv_template_id',
        'name',
        'primary_color',
        'secondary_color',
        'accent_color',
        'text_color',
        'background_color',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the template that owns this color scheme
     */
    public function template()
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($color) {
            if ($color->is_default) {
                static::where('cv_template_id', $color->cv_template_id)
                    ->where('id', '!=', $color->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Get color scheme as CSS variables
     */
    public function getCssVariablesAttribute()
    {
        return [
            '--cv-primary' => $this->primary_color,
            '--cv-secondary' => $this->secondary_color,
            '--cv-accent' => $this->accent_color,
            '--cv-text' => $this->text_color,
            '--cv-background' => $this->background_color,
        ];
    }
}