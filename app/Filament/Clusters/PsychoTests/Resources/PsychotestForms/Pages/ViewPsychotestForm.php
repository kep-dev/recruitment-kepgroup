<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages;

use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\PsychotestFormResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPsychotestForm extends ViewRecord
{
    protected static string $resource = PsychotestFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
