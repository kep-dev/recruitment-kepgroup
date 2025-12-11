<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\InterviewSessionResource;

class ListInterviewSessions extends ListRecords
{
    protected static string $resource = InterviewSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
