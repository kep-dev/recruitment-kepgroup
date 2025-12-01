<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages;

use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\ApplicantTestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApplicantTests extends ListRecords
{
    protected static string $resource = ApplicantTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
