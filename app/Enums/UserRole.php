<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case ANGGOTA = 'anggota';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::ANGGOTA => 'Anggota',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ADMIN => 'purple',
            self::ANGGOTA => 'blue',
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
