<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'rt_id',
        'type',
        'amount',
        'description',
        'transaction_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
            'type' => TransactionType::class,
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the category for this transaction.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user (admin) who created this transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the RT for this transaction.
     */
    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include income transactions.
     */
    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('type', TransactionType::INCOME);
    }

    /**
     * Scope a query to only include expense transactions.
     */
    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('type', TransactionType::EXPENSE);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
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
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->where('transaction_date', '>=', $from);
        }
        if ($to) {
            $query->where('transaction_date', '<=', $to);
        }
        return $query;
    }

    /**
     * Scope a query to filter by month.
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year);
    }

    /**
     * Scope a query to filter by year.
     */
    public function scopeThisYear(Builder $query): Builder
    {
        return $query->whereYear('transaction_date', now()->year);
    }

    /**
     * Scope a query to search by description.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where('description', 'like', "%{$search}%");
    }

    // ==================== ACCESSORS ====================

    /**
     * Get formatted amount with currency.
     */
    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->type === TransactionType::INCOME ? '+' : '-';
        return $prefix . 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get formatted amount without prefix.
     */
    public function getFormattedAmountPlainAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get transaction type badge HTML.
     */
    public function getTypeBadgeAttribute(): string
    {
        return sprintf(
            '<span class="%s">%s %s</span>',
            $this->type->badgeClass(),
            $this->type->icon(),
            $this->type->label()
        );
    }

    /**
     * Get formatted transaction date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->transaction_date->translatedFormat('d F Y');
    }

    /**
     * Get RT name or dash if not set.
     */
    public function getRtNameAttribute(): string
    {
        return $this->rt?->full_name ?? 'Umum';
    }
}
