<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_per_kg',
        'unit',
        'icon',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get all deposits for this waste type.
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(WasteDeposit::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active waste types.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search by name.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where('name', 'like', "%{$search}%");
    }

    // ==================== ACCESSORS ====================

    /**
     * Get formatted price per kg.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_kg, 0, ',', '.');
    }

    /**
     * Get total weight deposited for this waste type.
     */
    public function getTotalWeightAttribute(): float
    {
        return (float) $this->deposits()->sum('weight');
    }

    /**
     * Get total value of all deposits for this waste type.
     */
    public function getTotalValueAttribute(): float
    {
        return (float) $this->deposits()->sum('total_amount');
    }

    /**
     * Get formatted total value.
     */
    public function getFormattedTotalValueAttribute(): string
    {
        return 'Rp ' . number_format($this->total_value, 0, ',', '.');
    }

    /**
     * Get deposit count for this waste type.
     */
    public function getDepositCountAttribute(): int
    {
        return $this->deposits()->count();
    }
}
