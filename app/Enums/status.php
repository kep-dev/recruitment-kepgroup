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
    case assigned = 'assigned';
    case completed = 'completed';
    case expired = 'expired';
    case submitted = 'submitted';
    case graded = 'graded';
    case timeout = 'timeout';
    public function getLabel(): ?string
    {
        return match ($this) {
            self::pending => 'Ditunda',
            self::in_progress => 'Dalam Proses',
            self::passed => 'Lulus',
            self::failed => 'Gagal',
            self::skipped => 'Dilewati',
            self::assigned => 'Ditugaskan',
            self::completed => 'Selesai',
            self::expired => 'Kadaluarsa',
            self::submitted => 'Dikirim',
            self::graded => 'Dinilai',
            self::timeout => 'Waktu Habis',
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
            self::assigned => 'secondary',
            self::completed => 'success',
            self::expired => 'danger',
            self::submitted => 'secondary',
            self::graded => 'secondary',
            self::timeout => 'danger',
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
            self::assigned => 'heroicon-s-check-circle',
            self::completed => 'heroicon-s-check-circle',
            self::expired => 'heroicon-s-x-circle',
            self::submitted => 'heroicon-s-check-circle',
            self::graded => 'heroicon-s-check-circle',
            self::timeout => 'heroicon-s-x-circle',
        };
    }
}
