<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function getBillingPeriodLabelAttribute()
    {
        return ucfirst($this->billing_period);
    }

    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }
}
