<?php

namespace  App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages;


use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\JobVacancyTestResource;

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
