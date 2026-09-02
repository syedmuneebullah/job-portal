<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'target_user_type',
        'price',
        'currency',
        'billing_period',
        'features',
        'limits',
        'is_active',
        'trial_days',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'limits' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'trial_days' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Billing periods
    const BILLING_MONTHLY = 'monthly';
    const BILLING_QUARTERLY = 'quarterly';
    const BILLING_YEARLY = 'yearly';
    const BILLING_ONE_TIME = 'one_time';

    // Target user types
    const TARGET_ADMIN = 'admin';
    const TARGET_EMPLOYER = 'employer';
    const TARGET_RECRUITER = 'recruiter';
    const TARGET_APPLICANT = 'applicant';

    // Relationships
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByUserType($query, $type)
    {
        return $query->where('target_user_type', $type);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('description', 'LIKE', "%{$search}%");
        }
        return $query;
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function getBillingPeriodLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->billing_period));
    }

    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }

    public function getTargetUserTypeLabelAttribute()
    {
        return ucfirst($this->target_user_type);
    }

    public function getFeaturesListAttribute()
    {
        if (is_array($this->features)) {
            return $this->features;
        }
        return json_decode($this->features, true) ?? [];
    }

    public function getLimitsListAttribute()
    {
        if (is_array($this->limits)) {
            return $this->limits;
        }
        return json_decode($this->limits, true) ?? [];
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode($value);
        } else {
            $this->attributes['features'] = $value;
        }
    }

    public function setLimitsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['limits'] = json_encode($value);
        } else {
            $this->attributes['limits'] = $value;
        }
    }
}