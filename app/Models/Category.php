<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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
        'icon',
        'color',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get all transactions for this category.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the current balance for this category.
     */
    public function getBalanceAttribute(): float
    {
        return $this->total_income - $this->total_expense;
    }

    /**
     * Get total income for this category.
     */
    public function getTotalIncomeAttribute(): float
    {
        return (float) $this->transactions()
            ->where('type', 'income')
            ->sum('amount');
    }

    /**
     * Get total expense for this category.
     */
    public function getTotalExpenseAttribute(): float
    {
        return (float) $this->transactions()
            ->where('type', 'expense')
            ->sum('amount');
    }

    /**
     * Get transaction count for this category.
     */
    public function getTransactionCountAttribute(): int
    {
        return $this->transactions()->count();
    }

    /**
     * Get formatted balance.
     */
    public function getFormattedBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }

    /**
     * Get formatted total income.
     */
    public function getFormattedIncomeAttribute(): string
    {
        return 'Rp ' . number_format($this->total_income, 0, ',', '.');
    }

    /**
     * Get formatted total expense.
     */
    public function getFormattedExpenseAttribute(): string
    {
        return 'Rp ' . number_format($this->total_expense, 0, ',', '.');
    }

    // ==================== STATIC METHODS ====================

    /**
     * Get total balance across all categories.
     */
    public static function getTotalBalance(): float
    {
        return self::all()->sum('balance');
    }

    /**
     * Get formatted total balance across all categories.
     */
    public static function getFormattedTotalBalance(): string
    {
        return 'Rp ' . number_format(self::getTotalBalance(), 0, ',', '.');
    }
}
