<?php

namespace App\Filament\Resources\EmployeeTypes\Pages;

use App\Filament\Resources\EmployeeTypes\EmployeeTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployeeTypes extends ManageRecords
{
    protected static string $resource = EmployeeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
