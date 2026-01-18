<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'rw_id',
        'name',
        'description',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the RW that this RT belongs to.
     */
    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    /**
     * Get all residents in this RT.
     */
    public function residents(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all transactions for this RT.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get full name with RW (e.g., "RT 03 / RW 01").
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' / ' . $this->rw->name;
    }

    /**
     * Get the total number of active residents in this RT.
     */
    public function getResidentCountAttribute(): int
    {
        return $this->residents()->active()->count();
    }

    /**
     * Get total balance for this RT.
     */
    public function getTotalBalanceAttribute(): float
    {
        $income = $this->transactions()->where('type', 'income')->sum('amount');
        $expense = $this->transactions()->where('type', 'expense')->sum('amount');
        return (float) ($income - $expense);
    }

    /**
     * Get formatted total balance.
     */
    public function getFormattedBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_balance, 0, ',', '.');
    }
}
