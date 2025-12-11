<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\Pages;

use App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\InterviewSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInterviewSession extends CreateRecord
{
    protected static string $resource = InterviewSessionResource::class;
}
