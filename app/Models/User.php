<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'birth_date',
        'gender',
        'role',
        'status',
        'joined_at',
        'rejection_reason',
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
            'birth_date' => 'date',
            'joined_at' => 'date',
            'gender' => Gender::class,
            'role' => UserRole::class,
            'status' => UserStatus::class,
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get all transactions created by this user (admin).
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get all events created by this user (admin).
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', UserStatus::ACTIVE);
    }

    /**
     * Scope a query to only include pending users.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', UserStatus::PENDING);
    }

    /**
     * Scope a query to only include inactive users.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', UserStatus::INACTIVE);
    }

    /**
     * Scope a query to only include members (anggota).
     */
    public function scopeMembers(Builder $query): Builder
    {
        return $query->where('role', UserRole::ANGGOTA);
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('role', UserRole::ADMIN);
    }

    /**
     * Scope a query to search by name or email.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    // ==================== HELPERS ====================

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    /**
     * Check if user is a member.
     */
    public function isMember(): bool
    {
        return $this->role === UserRole::ANGGOTA;
    }

    /**
     * Check if user is approved (active).
     */
    public function isApproved(): bool
    {
        return $this->status === UserStatus::ACTIVE;
    }

    /**
     * Check if user is pending approval.
     */
    public function isPending(): bool
    {
        return $this->status === UserStatus::PENDING;
    }

    /**
     * Check if user is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === UserStatus::INACTIVE;
    }

    /**
     * Get user's age.
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date?->age ?? 0;
    }

    /**
     * Get user's formatted phone number.
     */
    public function getFormattedPhoneAttribute(): string
    {
        return $this->phone;
    }

    /**
     * Get user's status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        return sprintf(
            '<span class="%s">%s</span>',
            $this->status->badgeClass(),
            $this->status->label()
        );
    }
}
