<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Widgets;

use App\Models\JobVacancy;
use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;

class SelectPreMedicalWidget extends Widget
{
    protected string $view = 'filament.paramedic.resources.pre-medical-session-applications.widgets.select-pre-medical-widget';
    protected int | string | array $columnSpan = 'full';

    public string $jobVacancyId;

    #[Computed]
    public function jobVacancies()
    {
        return JobVacancy::query()
            ->where('status', true)
            ->pluck('title', 'id')
            ->toArray();
    }
}
