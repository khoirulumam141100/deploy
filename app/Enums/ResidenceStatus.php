<?php

namespace App\Enums;

enum ResidenceStatus: string
{
    case TETAP = 'tetap';
    case KONTRAK = 'kontrak';
    case KOS = 'kos';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::TETAP => 'Warga Tetap',
            self::KONTRAK => 'Kontrak',
            self::KOS => 'Kos',
        };
    }

    /**
     * Get badge CSS class.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::TETAP => 'badge-success',
            self::KONTRAK => 'badge-warning',
            self::KOS => 'badge-info',
        };
    }

    /**
     * Get icon for display.
     */
    public function icon(): string
    {
        return match ($this) {
            self::TETAP => '🏠',
            self::KONTRAK => '📄',
            self::KOS => '🛏️',
        };
    }
}
