<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Illuminate\Support\Facades\Blade;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Wizard\Step;

class PreMedicalSessionApplicationComponent extends Component
{
    protected string $view = 'filament.schemas.components.pre-medical-session-application-component';

    public static function make(): static
    {
        return app(static::class);
    }

}
