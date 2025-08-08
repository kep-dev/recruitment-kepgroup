<?php

namespace App\Filament\Resources\WorkTypes\Pages;

use App\Filament\Resources\WorkTypes\WorkTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWorkTypes extends ManageRecords
{
    protected static string $resource = WorkTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
