<?php

namespace App\Filament\Resources\Placements\Pages;

use App\Filament\Resources\Placements\PlacementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePlacements extends ManageRecords
{
    protected static string $resource = PlacementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
