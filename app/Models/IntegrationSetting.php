<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'api_key',
        'api_secret',
        'settings',
        'status',
        'last_sync_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'last_sync_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
