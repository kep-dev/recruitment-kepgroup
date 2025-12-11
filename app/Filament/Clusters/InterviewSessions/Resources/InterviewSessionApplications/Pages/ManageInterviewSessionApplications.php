<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessionApplications\Pages;

use App\Filament\Clusters\InterviewSessions\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageInterviewSessionApplications extends ManageRecords
{
    protected static string $resource = InterviewSessionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
