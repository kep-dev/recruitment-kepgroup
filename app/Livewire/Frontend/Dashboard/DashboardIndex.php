<?php

namespace App\Livewire\Frontend\Dashboard;

use App\Models\JobVacancy;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title, Computed};

#[Layout('components.layouts.app')]
#[Title('Home')]
class DashboardIndex extends Component
{
    #[Computed]
    public function jobVacancies()
    {
        return JobVacancy::query()
            ->with([
                'workType',
                'employeeType',
                'jobLevel',
                'benefits',
                'placements'
            ])
            ->where('status', true)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.dashboard.dashboard-index');
    }
}
