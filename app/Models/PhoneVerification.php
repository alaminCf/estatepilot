<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    protected $fillable = [
        'phone',
        'code',
        'type',
        'expires_at',
        'verified',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean',
    ];

    /**
     * Check if the code is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the code is valid
     */
    public function isValid(string $code): bool
    {
        return !$this->isExpired() && !$this->verified && $this->code === $code;
    }

    /**
     * Mark as verified
     */
    public function markAsVerified(): void
    {
        $this->update(['verified' => true]);
    }

    /**
     * Scope for registration type
     */
    public function scopeRegistration($query)
    {
        return $query->where('type', 'registration');
    }

    /**
     * Scope for password reset type
     */
    public function scopePasswordReset($query)
    {
        return $query->where('type', 'password_reset');
    }

    /**
     * Scope for active (not expired and not verified)
     */
    public function scopeActive($query)
    {
        return $query->where('verified', false)
                     ->where('expires_at', '>', now());
    }
}
