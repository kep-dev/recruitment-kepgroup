<?php

namespace App\Filament\Resources\VacancyDocuments\Pages;

use App\Filament\Resources\VacancyDocuments\VacancyDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVacancyDocuments extends ManageRecords
{
    protected static string $resource = VacancyDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
