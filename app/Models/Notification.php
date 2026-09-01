<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'channel',
        'is_read',
        'read_at',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Channel constants
    const CHANNEL_EMAIL = 'email';
    const CHANNEL_SMS = 'sms';
    const CHANNEL_PUSH = 'push';
    const CHANNEL_IN_APP = 'in_app';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }

    public function scopeInApp($query)
    {
        return $query->where('channel', self::CHANNEL_IN_APP);
    }

    // Accessors
    public function getChannelLabelAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->channel));
    }

    public function getIsReadAttribute($value)
    {
        return (bool) $value;
    }

    // Mutators
    public function markAsRead()
    {
        $this->is_read = true;
        $this->read_at = now();
        $this->save();
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();
    }

    public function markAsSent()
    {
        $this->sent_at = now();
        $this->save();
    }

    public function markAsDelivered()
    {
        $this->delivered_at = now();
        $this->save();
    }
}
