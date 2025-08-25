<?php

namespace App\Filament\Resources\StageTypes\Pages;

use App\Filament\Resources\StageTypes\StageTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStageTypes extends ManageRecords
{
    protected static string $resource = StageTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
