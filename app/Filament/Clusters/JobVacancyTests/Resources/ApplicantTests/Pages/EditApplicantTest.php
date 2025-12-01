<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages;

use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\ApplicantTestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicantTest extends EditRecord
{
    protected static string $resource = ApplicantTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
