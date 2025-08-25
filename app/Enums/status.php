<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum status: string implements HasLabel, HasIcon
{
    case pending = 'pending';
    case in_progress = 'in_progress';
    case passed = 'passed';
    case failed = 'failed';
    case skipped = 'skipped';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::pending => 'Ditunda',
            self::in_progress => 'Dalam Proses',
            self::passed => 'Lulus',
            self::failed => 'Gagal',
            self::skipped => 'Dilewati',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::pending => 'warning',
            self::in_progress => 'primary',
            self::passed => 'success',
            self::failed => 'danger',
            self::skipped => 'secondary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::pending => 'heroicon-s-clock',
            self::in_progress => 'heroicon-s-clock',
            self::passed => 'heroicon-s-check-circle',
            self::failed => 'heroicon-s-x-circle',
            self::skipped => 'heroicon-s-x-circle',
        };
    }
}
