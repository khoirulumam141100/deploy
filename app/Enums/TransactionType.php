<?php

namespace App\Enums;

enum TransactionType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public function label(): string
    {
        return match ($this) {
            self::INCOME => 'Pemasukan',
            self::EXPENSE => 'Pengeluaran',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::INCOME => 'green',
            self::EXPENSE => 'red',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::INCOME => 'badge-success',
            self::EXPENSE => 'badge-danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::INCOME => '↑',
            self::EXPENSE => '↓',
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
