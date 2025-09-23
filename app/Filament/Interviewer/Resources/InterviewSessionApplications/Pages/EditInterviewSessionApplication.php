<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages;

use App\Filament\Interviewer\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInterviewSessionApplication extends EditRecord
{
    protected static string $resource = InterviewSessionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
