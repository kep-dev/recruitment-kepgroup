<?php

namespace App\Filament\Schemas\Components\Applicant;

use Filament\Schemas\Components\Component;

class ApplicationResult extends Component
{
    protected string $view = 'filament.schemas.components.applicant.application-result';

    public static function make(): static
    {
        return app(static::class);
    }
}
