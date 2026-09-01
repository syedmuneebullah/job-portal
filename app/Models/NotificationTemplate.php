<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'subject',
        'content',
        'placeholders',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'placeholders' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Type constants
    const TYPE_EMAIL = 'email';
    const TYPE_SMS = 'sms';
    const TYPE_PUSH = 'push';

    // Relationships
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }
}
