<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\ResidenceStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        // New fields for RT/RW
        'rt_id',
        'rw_id',
        'nik',
        'residence_status',
        'occupation',
        'waste_balance',
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
            'residence_status' => ResidenceStatus::class,
            'waste_balance' => 'decimal:2',
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

    /**
     * Get the RT that this user belongs to.
     */
    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    /**
     * Get the RW that this user belongs to.
     */
    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    /**
     * Get all waste deposits for this user.
     */
    public function wasteDeposits(): HasMany
    {
        return $this->hasMany(WasteDeposit::class);
    }

    /**
     * Get all waste redemptions for this user.
     */
    public function wasteRedemptions(): HasMany
    {
        return $this->hasMany(WasteRedemption::class);
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
     * Scope a query to only include members/residents (warga).
     */
    public function scopeResidents(Builder $query): Builder
    {
        return $query->where('role', UserRole::ANGGOTA);
    }

    /**
     * Scope a query to only include members (alias for residents).
     * @deprecated Use scopeResidents instead
     */
    public function scopeMembers(Builder $query): Builder
    {
        return $this->scopeResidents($query);
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('role', UserRole::ADMIN);
    }

    /**
     * Scope a query to filter by RT.
     */
    public function scopeByRt(Builder $query, ?int $rtId): Builder
    {
        if (!$rtId) {
            return $query;
        }
        return $query->where('rt_id', $rtId);
    }

    /**
     * Scope a query to filter by RW.
     */
    public function scopeByRw(Builder $query, ?int $rwId): Builder
    {
        if (!$rwId) {
            return $query;
        }
        return $query->where('rw_id', $rwId);
    }

    /**
     * Scope a query to search by name, email, NIK, or phone.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%");
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
     * Check if user is a member/resident.
     */
    public function isMember(): bool
    {
        return $this->role === UserRole::ANGGOTA;
    }

    /**
     * Alias for isMember - check if user is a resident.
     */
    public function isResident(): bool
    {
        return $this->isMember();
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
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE;
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

    /**
     * Get full RT/RW name (e.g., "RT 03 / RW 01").
     */
    public function getFullRtRwAttribute(): string
    {
        if (!$this->rt) {
            return '-';
        }
        return $this->rt->name . ' / ' . $this->rt->rw->name;
    }

    /**
     * Get formatted waste balance.
     */
    public function getFormattedWasteBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->waste_balance ?? 0, 0, ',', '.');
    }

    /**
     * Get residence status badge HTML.
     */
    public function getResidenceStatusBadgeAttribute(): string
    {
        if (!$this->residence_status) {
            return '-';
        }
        return sprintf(
            '<span class="%s">%s %s</span>',
            $this->residence_status->badgeClass(),
            $this->residence_status->icon(),
            $this->residence_status->label()
        );
    }

    /**
     * Get total waste deposited by this user (in kg).
     */
    public function getTotalWasteDepositedAttribute(): float
    {
        return (float) $this->wasteDeposits()->sum('weight');
    }

    /**
     * Get total waste deposit count.
     */
    public function getWasteDepositCountAttribute(): int
    {
        return $this->wasteDeposits()->count();
    }

    /**
     * Add to waste balance (when deposit is made).
     */
    public function addWasteBalance(float $amount): void
    {
        $this->waste_balance = ($this->waste_balance ?? 0) + $amount;
        $this->save();
    }

    /**
     * Deduct from waste balance (when redemption is made).
     */
    public function deductWasteBalance(float $amount): bool
    {
        if (($this->waste_balance ?? 0) < $amount) {
            return false;
        }
        $this->waste_balance -= $amount;
        $this->save();
        return true;
    }
}
