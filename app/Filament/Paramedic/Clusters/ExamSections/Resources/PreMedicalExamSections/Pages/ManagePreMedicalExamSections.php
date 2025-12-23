<?php

namespace App\Filament\Paramedic\Clusters\ExamSections\Resources\PreMedicalExamSections\Pages;

use App\Filament\Paramedic\Clusters\ExamSections\Resources\PreMedicalExamSections\PreMedicalExamSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePreMedicalExamSections extends ManageRecords
{
    protected static string $resource = PreMedicalExamSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
