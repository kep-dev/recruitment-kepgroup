<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;
use Filament\Support\Enums\Width;

class ViewInterviewSessionApplication extends ViewRecord
{
    protected static string $resource = InterviewSessionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
