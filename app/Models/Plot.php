<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'plot_no',
        'size_katha',
        'block',
        'road_no',
        'facing',
        'agent_name',
        'plot_category',
        'road_width',
        'price',
        'booking_payment',
        'remaining_payment',
        'installment_plan',
        'total_installments',
        'installment_payment',
        'plot_map',
        'google_maps_location',
        'nearby_facilities',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'size_katha' => 'decimal:2',
        'price' => 'decimal:2',
        'booking_payment' => 'decimal:2',
        'remaining_payment' => 'decimal:2',
        'installment_payment' => 'decimal:2',
    ];

    /**
     * Get all bookings for this plot.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the current active booking for this plot.
     */
    public function currentBooking()
    {
        return $this->hasOne(Booking::class)
            ->whereIn('status', ['confirmed', 'approved'])
            ->latest();
    }
}
