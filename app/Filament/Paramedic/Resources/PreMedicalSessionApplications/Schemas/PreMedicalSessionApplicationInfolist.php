<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\View;

class PreMedicalSessionApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

            ]);
    }



}
