<?php

namespace App\Enums;

enum RedemptionType: string
{
    case CASH = 'cash';
    case GOODS = 'goods';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Tunai',
            self::GOODS => 'Barang',
        };
    }

    /**
     * Get icon for display.
     */
    public function icon(): string
    {
        return match ($this) {
            self::CASH => '💵',
            self::GOODS => '🎁',
        };
    }
}
