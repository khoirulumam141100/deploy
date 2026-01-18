<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Rw extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get all RTs in this RW.
     */
    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }

    /**
     * Get all residents in this RW through RTs.
     */
    public function residents(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Rt::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the total number of residents in this RW.
     */
    public function getResidentCountAttribute(): int
    {
        return $this->residents()->active()->count();
    }

    /**
     * Get the total number of RTs in this RW.
     */
    public function getRtCountAttribute(): int
    {
        return $this->rts()->count();
    }
}
