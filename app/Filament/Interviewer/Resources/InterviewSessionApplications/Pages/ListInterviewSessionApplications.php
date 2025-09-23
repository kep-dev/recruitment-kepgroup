<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages;

use App\Filament\Interviewer\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInterviewSessionApplications extends ListRecords
{
    protected static string $resource = InterviewSessionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
