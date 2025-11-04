<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages;

use Filament\Actions\EditAction;
use Filament\Support\Enums\Width;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\PreMedicalSessionApplicationResource;

class ViewPreMedicalSessionApplication extends ViewRecord
{
    protected static string $resource = PreMedicalSessionApplicationResource::class;

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
