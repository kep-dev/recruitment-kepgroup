<?php

namespace App\Filament\Resources\InterviewSessions\Pages;

use App\Filament\Resources\InterviewSessions\InterviewSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

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
