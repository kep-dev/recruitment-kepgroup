<?php

namespace App\Filament\Resources\JobVacancyTests\Pages;

use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

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
