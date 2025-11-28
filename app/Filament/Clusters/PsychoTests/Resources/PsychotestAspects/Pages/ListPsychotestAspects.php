<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages;

use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\PsychotestAspectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPsychotestAspects extends ListRecords
{
    protected static string $resource = PsychotestAspectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
