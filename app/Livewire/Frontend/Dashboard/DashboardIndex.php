<?php

namespace App\Livewire\Frontend\Dashboard;

use Livewire\Component;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;
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
            ])
            ->whereDate('end_date', '>', \Carbon\Carbon::now())
            ->where('status', true)
            ->latest()
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.dashboard.dashboard-index');
    }
}
