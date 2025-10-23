<?php

namespace App\Filament\Resources\PreMedicalSessions\Pages;

use App\Filament\Resources\PreMedicalSessions\PreMedicalSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPreMedicalSession extends EditRecord
{
    protected static string $resource = PreMedicalSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
