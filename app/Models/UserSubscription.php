<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'stripe_id',
        'paystack_id',
        'status',
        'trial_ends_at',
        'ends_at',
        'next_billing_at',
        'custom_features',
    ];

    protected $casts = [
        'custom_features' => 'array',
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
        'next_billing_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';
    const STATUS_TRIAL = 'trial';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeTrial($query)
    {
        return $query->where('status', self::STATUS_TRIAL);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        return $this->status === self::STATUS_ACTIVE ||
               ($this->status === self::STATUS_TRIAL && $this->trial_ends_at > now());
    }

    public function getIsTrialAttribute()
    {
        return $this->status === self::STATUS_TRIAL && $this->trial_ends_at > now();
    }

    public function getIsExpiredAttribute()
    {
        return $this->status === self::STATUS_EXPIRED ||
               ($this->ends_at && $this->ends_at < now());
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->ends_at) {
            return now()->diffInDays($this->ends_at, false);
        }
        return null;
    }

    public function getRemainingTrialDaysAttribute()
    {
        if ($this->trial_ends_at) {
            return now()->diffInDays($this->trial_ends_at, false);
        }
        return null;
    }

    // Mutators
    public function markAsExpired()
    {
        $this->status = self::STATUS_EXPIRED;
        $this->save();
    }

    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        $this->ends_at = now();
        $this->save();
    }

    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }
}
