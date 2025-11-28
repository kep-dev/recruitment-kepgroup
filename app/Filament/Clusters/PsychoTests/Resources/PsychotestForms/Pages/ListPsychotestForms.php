<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages;

use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\PsychotestFormResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPsychotestForms extends ListRecords
{
    protected static string $resource = PsychotestFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
