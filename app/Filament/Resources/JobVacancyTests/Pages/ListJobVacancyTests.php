<?php

namespace App\Filament\Resources\JobVacancyTests\Pages;

use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobVacancyTests extends ListRecords
{
    protected static string $resource = JobVacancyTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
