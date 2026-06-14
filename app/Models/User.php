<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected static function booted(): void
    {
        static::creating(function ($user) {
            if ($user->role === 'user' && empty($user->client_id)) {
                $user->client_id = (static::max('client_id') ?? 0) + 1;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'commission_type',
        'parent_id',
        'booking_pct',
        'down_pct',
        'instalment_pct',
        'profile_image',
        'phone',
        'emergency_phone',
        'address',
        'photo',
        'father_name',
        'mother_name',
        'spouse_name',
        'nid',
        'nominee_name',
        'nominee_nid',
        'nominee_photo',
        'nominee_relation',
        'status',
        'commission_rate',
        'referral_code',
        'permissions',
        'client_id',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
            'booking_pct' => 'decimal:2',
            'down_pct' => 'decimal:2',
            'instalment_pct' => 'decimal:2',
        ];
    }

    /**
     * All available CRM permission modules (sections).
     */
    public const PERMISSIONS = [
        'manage_plots' => 'Manage Plots',
        'manage_bookings' => 'Manage Bookings',
        'manage_payments' => 'Manage Payments',
        'manage_customers' => 'Manage Customers',
        'manage_commission_users' => 'Manage Commission Users',
        'manage_reports' => 'Manage Reports',
        'manage_settings' => 'Manage Settings',
    ];

    /**
     * Granular actions available for each permission module.
     */
    public const PERMISSION_ACTIONS = [
        'view' => 'View',
        'add' => 'Add',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ];

    /**
     * Every assignable "module.action" permission key.
     *
     * @return list<string>
     */
    public static function allPermissions(): array
    {
        $all = [];

        foreach (array_keys(self::PERMISSIONS) as $module) {
            foreach (array_keys(self::PERMISSION_ACTIONS) as $action) {
                $all[] = "{$module}.{$action}";
            }
        }

        return $all;
    }

    /**
     * Check if the user has a specific permission.
     *
     * Accepts either a module key ("manage_plots") for section-level access
     * or a granular "module.action" key ("manage_plots.add"). A module is
     * considered accessible when the user holds at least one of its actions.
     * Legacy bare module keys grant every action of that module.
     */
    public function hasPermission(string $permission): bool
    {
        // Super admin (id=1) always has all permissions.
        if ($this->id === 1) {
            return true;
        }

        $permissions = $this->permissions ?? [];

        // Exact match (granular "module.action" or legacy bare module key).
        if (in_array($permission, $permissions, true)) {
            return true;
        }

        if (str_contains($permission, '.')) {
            // Granular check: a stored legacy bare module key implies all actions.
            $module = strtok($permission, '.');

            return in_array($module, $permissions, true);
        }

        // Section-level check: accessible if any action of the module is granted.
        foreach ($permissions as $granted) {
            if (str_starts_with($granted, "{$permission}.")) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convenience check for a granular module action (View/Add/Edit/Delete).
     */
    public function canDo(string $module, ?string $action = null): bool
    {
        if ($action === null) {
            return $this->hasPermission($module);
        }

        return $this->hasPermission("{$module}.{$action}");
    }

    /**
     * Permissions grouped by module label for display, e.g.
     * ['Manage Plots' => ['View', 'Add'], ...].
     *
     * @return array<string, list<string>>
     */
    public function groupedPermissions(): array
    {
        $grouped = [];

        foreach ($this->permissions ?? [] as $permission) {
            [$module, $action] = array_pad(explode('.', $permission, 2), 2, null);

            $moduleLabel = self::PERMISSIONS[$module] ?? $module;
            $actionLabel = $action ? (self::PERMISSION_ACTIONS[$action] ?? $action) : 'All';

            $grouped[$moduleLabel][] = $actionLabel;
        }

        return $grouped;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is agent.
     *
     * Note: the stored role value remains 'agent' for commission users;
     * only the presentation layer was renamed. Prefer isCommissionUser().
     */
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Check if user is a commission user (E.D / G.M / AGM / Manager / Ast. Manager).
     */
    public function isCommissionUser(): bool
    {
        return $this->isAgent();
    }

    /**
     * Scope query to commission users only.
     */
    public function scopeCommissionUsers($query)
    {
        return $query->where('role', 'agent');
    }

    /**
     * Display label for the commission type (e.g. "E.D", "Ast. Manager").
     */
    public function commissionTypeLabel(): ?string
    {
        return $this->commission_type
            ? config("commission.types.{$this->commission_type}.label", $this->commission_type)
            : null;
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get formatted Client ID (CID-XXXXX).
     */
    public function getFormattedClientIdAttribute(): string
    {
        return 'CID-' . str_pad($this->client_id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get user profile image URL
     */
    public function getProfileImageUrlAttribute(): string
    {
        // First check if photo field exists and has a value
        $imagePath = $this->attributes['photo'] ?? $this->attributes['profile_image'] ?? null;
        
        if ($imagePath && file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        // Return default image
        return asset('assets/user.webp');
    }

    /**
     * Get all bookings for this user.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all bookings referred by this agent.
     */
    public function referredBookings()
    {
        return $this->hasMany(Booking::class, 'referral_agent_id');
    }

    /**
     * The immediate upline in the commission hierarchy.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Direct downline commission users.
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Commission earnings received by this user (as seller or upline).
     */
    public function commissionEarnings()
    {
        return $this->hasMany(CommissionEarning::class, 'user_id');
    }

    /**
     * Commission payouts made to this user.
     */
    public function commissionPayouts()
    {
        return $this->hasMany(CommissionPayout::class, 'user_id');
    }

    /**
     * Get all payments for this user through bookings.
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Booking::class);
    }
}
