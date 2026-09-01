<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'invoice_number',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'currency',
        'line_items',
        'issued_at',
        'due_at',
        'paid_at',
        'status',
        'pdf_path',
    ];

    protected $casts = [
        'line_items' => 'array',
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'issued_at' => 'datetime',
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_ISSUED = 'issued';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';
    const STATUS_CANCELLED = 'cancelled';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Scopes
    public function scopeIssued($query)
    {
        return $query->where('status', self::STATUS_ISSUED);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getTotalWithTaxAttribute()
    {
        return $this->total_amount + $this->tax_amount - $this->discount_amount;
    }

    public function getFormattedTotalAttribute()
    {
        return $this->currency . ' ' . number_format($this->total_with_tax, 2);
    }

    public function getIsPaidAttribute()
    {
        return $this->status === self::STATUS_PAID;
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === self::STATUS_OVERDUE ||
               ($this->status === self::STATUS_ISSUED && $this->due_at < now());
    }

    // Mutators
    public function markAsPaid()
    {
        $this->status = self::STATUS_PAID;
        $this->paid_at = now();
        $this->save();
    }

    public function markAsOverdue()
    {
        $this->status = self::STATUS_OVERDUE;
        $this->save();
    }

    public function markAsIssued()
    {
        $this->status = self::STATUS_ISSUED;
        $this->issued_at = now();
        $this->save();
    }
}
