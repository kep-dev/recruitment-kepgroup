<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\InterviewSessionResource;

class EditInterviewSession extends EditRecord
{
    protected static string $resource = InterviewSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
