<?php

namespace App\Filament\Resources\PreMedicalSessions\Pages;

use App\Filament\Resources\PreMedicalSessions\PreMedicalSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPreMedicalSession extends ViewRecord
{
    protected static string $resource = PreMedicalSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
