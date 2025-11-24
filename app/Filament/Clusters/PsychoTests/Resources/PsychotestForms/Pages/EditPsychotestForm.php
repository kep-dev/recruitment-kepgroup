<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages;

use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\PsychotestFormResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPsychotestForm extends EditRecord
{
    protected static string $resource = PsychotestFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
