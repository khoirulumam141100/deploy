<?php

namespace App\Enums;

enum RedemptionStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::COMPLETED => 'Selesai',
            self::REJECTED => 'Ditolak',
        };
    }

    /**
     * Get badge CSS class.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'badge-warning',
            self::COMPLETED => 'badge-success',
            self::REJECTED => 'badge-danger',
        };
    }

    /**
     * Get icon for display.
     */
    public function icon(): string
    {
        return match ($this) {
            self::PENDING => '⏳',
            self::COMPLETED => '✅',
            self::REJECTED => '❌',
        };
    }
}
