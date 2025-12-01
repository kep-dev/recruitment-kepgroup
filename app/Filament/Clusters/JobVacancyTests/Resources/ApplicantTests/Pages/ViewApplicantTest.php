<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages;

use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\ApplicantTestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApplicantTest extends ViewRecord
{
    protected static string $resource = ApplicantTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
