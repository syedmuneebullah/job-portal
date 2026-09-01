<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'transaction_id',
        'gateway',
        'gateway_transaction_id',
        'amount',
        'currency',
        'type',
        'status',
        'metadata',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Type constants
    const TYPE_SUBSCRIPTION = 'subscription';
    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';
    const TYPE_CREDIT = 'credit';
    const TYPE_COMMISSION = 'commission';

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_DISPUTED = 'disputed';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    public function getIsSuccessfulAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // Mutators
    public function markAsCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->paid_at = now();
        $this->save();
    }

    public function markAsFailed()
    {
        $this->status = self::STATUS_FAILED;
        $this->save();
    }
}
