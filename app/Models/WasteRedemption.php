<?php

namespace App\Models;

use App\Enums\RedemptionStatus;
use App\Enums\RedemptionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteRedemption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'redemption_type',
        'status',
        'notes',
        'processed_by',
        'processed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'redemption_type' => RedemptionType::class,
            'status' => RedemptionStatus::class,
            'processed_at' => 'datetime',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the user (resident) who requested this redemption.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who processed this redemption.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to filter by user.
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus(Builder $query, RedemptionStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending redemptions.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', RedemptionStatus::PENDING);
    }

    /**
     * Scope a query to only include completed redemptions.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', RedemptionStatus::COMPLETED);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status badge HTML.
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
     * Check if redemption is pending.
     */
    public function isPending(): bool
    {
        return $this->status === RedemptionStatus::PENDING;
    }

    /**
     * Check if redemption is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === RedemptionStatus::COMPLETED;
    }
}
