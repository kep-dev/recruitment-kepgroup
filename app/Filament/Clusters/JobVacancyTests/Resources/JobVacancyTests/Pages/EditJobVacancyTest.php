<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages;


use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\JobVacancyTestResource;

class EditJobVacancyTest extends EditRecord
{
    protected static string $resource = JobVacancyTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
