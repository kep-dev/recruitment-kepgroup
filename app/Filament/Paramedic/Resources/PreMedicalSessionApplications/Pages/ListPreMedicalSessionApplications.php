<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Widgets\SelectPreMedicalWidget;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\PreMedicalSessionApplicationResource;

class ListPreMedicalSessionApplications extends ListRecords
{
    protected static string $resource = PreMedicalSessionApplicationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            // SelectPreMedicalWidget::class,
            //
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
