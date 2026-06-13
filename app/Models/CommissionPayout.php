<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'amount',
        'payment_note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * The commission user this payout was made to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optional booking reference (legacy per-booking payouts).
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
