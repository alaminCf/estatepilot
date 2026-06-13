<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'booking_id',
        'user_id',
        'seller_id',
        'level',
        'beneficiary_type',
        'pool_type',
        'pool_rate',
        'percentage',
        'amount',
        'created_at',
    ];

    protected $casts = [
        'level' => 'integer',
        'pool_rate' => 'decimal:2',
        'percentage' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    /**
     * The customer payment this earning was distributed from.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the booking for this earning.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * The commission user who receives this earning.
     */
    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The commission user who made the sale.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Whether this row is the seller's own share (level 0) or an upline override.
     */
    public function isOwnSale(): bool
    {
        return $this->level === 0;
    }
}
