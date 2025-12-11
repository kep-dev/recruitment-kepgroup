<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\Pages;

use App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\InterviewSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInterviewSession extends ViewRecord
{
    protected static string $resource = InterviewSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
