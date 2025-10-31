<?php

namespace App\Filament\Schemas\Components\Applicant;

use Filament\Schemas\Components\Component;

class ApplicantSnapshot extends Component
{
    protected string $view = 'filament.schemas.components.applicant.applicant-snapshot';

    // public $profileSnapshot;

    public static function make(): static
    {
        return app(static::class);
    }
}
