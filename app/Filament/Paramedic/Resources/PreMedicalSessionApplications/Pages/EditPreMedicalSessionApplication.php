<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages;

use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\PreMedicalSessionApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPreMedicalSessionApplication extends EditRecord
{
    protected static string $resource = PreMedicalSessionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
