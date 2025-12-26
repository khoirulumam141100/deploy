<?php

namespace App\Enums;

enum EventStatus: string
{
    case UPCOMING = 'upcoming';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::UPCOMING => 'Akan Datang',
            self::ONGOING => 'Sedang Berlangsung',
            self::COMPLETED => 'Selesai',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::UPCOMING => 'blue',
            self::ONGOING => 'yellow',
            self::COMPLETED => 'gray',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::UPCOMING => 'badge-info',
            self::ONGOING => 'badge-warning',
            self::COMPLETED => 'badge-success',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
