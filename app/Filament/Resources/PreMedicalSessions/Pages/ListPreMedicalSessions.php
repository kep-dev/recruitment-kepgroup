<?php

namespace App\Filament\Resources\PreMedicalSessions\Pages;

use App\Filament\Resources\PreMedicalSessions\PreMedicalSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPreMedicalSessions extends ListRecords
{
    protected static string $resource = PreMedicalSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
