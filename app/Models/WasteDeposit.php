<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteDeposit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'waste_type_id',
        'weight',
        'price_per_kg',
        'total_amount',
        'deposit_date',
        'notes',
        'recorded_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'price_per_kg' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'deposit_date' => 'date',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the user (resident) who made this deposit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the waste type for this deposit.
     */
    public function wasteType(): BelongsTo
    {
        return $this->belongsTo(WasteType::class);
    }

    /**
     * Get the admin who recorded this deposit.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
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
     * Scope a query to filter by waste type.
     */
    public function scopeByWasteType(Builder $query, int $wasteTypeId): Builder
    {
        return $query->where('waste_type_id', $wasteTypeId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->where('deposit_date', '>=', $from);
        }
        if ($to) {
            $query->where('deposit_date', '<=', $to);
        }
        return $query;
    }

    /**
     * Scope a query to filter this month.
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('deposit_date', now()->month)
            ->whereYear('deposit_date', now()->year);
    }

    /**
     * Scope a query to filter this year.
     */
    public function scopeThisYear(Builder $query): Builder
    {
        return $query->whereYear('deposit_date', now()->year);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get formatted total amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get formatted weight with unit.
     */
    public function getFormattedWeightAttribute(): string
    {
        return number_format($this->weight, 2, ',', '.') . ' kg';
    }

    /**
     * Get formatted deposit date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->deposit_date->translatedFormat('d F Y');
    }

    /**
     * Get formatted price per kg.
     */
    public function getFormattedPricePerKgAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_kg, 0, ',', '.');
    }
}
