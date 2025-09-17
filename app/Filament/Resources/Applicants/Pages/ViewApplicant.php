<?php

namespace App\Filament\Resources\Applicants\Pages;

use Filament\Actions\EditAction;
use Filament\Support\Enums\Width;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Applicants\ApplicantResource;

class ViewApplicant extends ViewRecord
{
    protected static string $resource = ApplicantResource::class;

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        $this->record->load([
            'user.roles',
            'skills',
            'functionOfInterests',
            'languages',
            'socialMedias',
            'salaries',
        ]);
    }
}
