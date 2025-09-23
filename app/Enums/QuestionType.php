<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum QuestionType : string implements HasLabel, HasIcon
{
    case multiple_choice = 'multiple_choice';
    case essay = 'essay';
    case true_false = 'true_false';
    case fill_in_blank = 'fill_in_blank';
    case matching = 'matching';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::multiple_choice => 'Pilihan Ganda',
            self::essay => 'Essay',
            self::true_false => 'Benar/Salah',
            self::fill_in_blank => 'Isi Kosong',
            self::matching => 'Penyesuaian',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::multiple_choice => 'primary',
            self::essay => 'secondary',
            self::true_false => 'secondary',
            self::fill_in_blank => 'secondary',
            self::matching => 'secondary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::multiple_choice => 'heroicon-s-check-circle',
            self::essay => 'heroicon-s-check-circle',
            self::true_false => 'heroicon-s-check-circle',
            self::fill_in_blank => 'heroicon-s-check-circle',
            self::matching => 'heroicon-s-check-circle',
        };
    }
}
