<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'application_id',
        'content',
        'type',
        'file_path',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBySender($query, $userId)
    {
        return $query->where('sender_id', $userId);
    }

    public function scopeByReceiver($query, $userId)
    {
        return $query->where('receiver_id', $userId);
    }

    public function scopeBetween($query, $user1Id, $user2Id)
    {
        return $query->where(function($q) use ($user1Id, $user2Id) {
            $q->where('sender_id', $user1Id)->where('receiver_id', $user2Id);
        })->orWhere(function($q) use ($user1Id, $user2Id) {
            $q->where('sender_id', $user2Id)->where('receiver_id', $user1Id);
        });
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    public function getIsImageAttribute()
    {
        return $this->type === 'image';
    }

    public function getIsFileAttribute()
    {
        return $this->type === 'file';
    }
}
