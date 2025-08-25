<?php

namespace App\Filament\Resources\JobVacancyTests\Pages;

use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobVacancyTest extends ViewRecord
{
    protected static string $resource = JobVacancyTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
