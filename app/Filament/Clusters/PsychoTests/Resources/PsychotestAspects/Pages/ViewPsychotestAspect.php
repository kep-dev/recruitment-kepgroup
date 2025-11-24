<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages;

use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\PsychotestAspectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPsychotestAspect extends ViewRecord
{
    protected static string $resource = PsychotestAspectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
