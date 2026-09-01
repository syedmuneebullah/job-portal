<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByModel($query, $modelType, $modelId = null)
    {
        $query->where('model_type', $modelType);
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        return $query;
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    // Accessors
    public function getActionLabelAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->action));
    }

    public function getModelNameAttribute()
    {
        if ($this->model_type) {
            $parts = explode('\\', $this->model_type);
            return end($parts);
        }
        return null;
    }

    public function getChangesAttribute()
    {
        if ($this->old_values && $this->new_values) {
            $changes = [];
            foreach ($this->new_values as $key => $value) {
                if (isset($this->old_values[$key]) && $this->old_values[$key] != $value) {
                    $changes[$key] = [
                        'old' => $this->old_values[$key],
                        'new' => $value,
                    ];
                }
            }
            return $changes;
        }
        return null;
    }
}
