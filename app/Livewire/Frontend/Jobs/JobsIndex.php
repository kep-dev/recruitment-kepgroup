<?php

namespace App\Livewire\Frontend\Jobs;

use Livewire\Component;
use App\Models\JobLevel;
use App\Models\WorkType;
use App\Models\JobVacancy;
use App\Models\EmployeeType;
use Livewire\WithPagination;
use App\Models\JobVacancyBookmark;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, Layout, Title};

#[Layout('components.layouts.app')]
#[Title('Lowongan')]
class JobsIndex extends Component
{
    use WithPagination;

    public $search;
    public $jobLevelId;
    public $employeeTypeId;
    public $workTypeId;
    public array $bookmarks = [];
    public array $applications = [];

    public function mount()
    {
        $this->bookmarks = auth()->user()?->jobVacancyBookmarks()->pluck('job_vacancy_id')->toArray() ?? [];
        $this->applications = auth()->user()?->applications()->pluck('job_vacancy_id')->toArray() ?? [];
    }
    #[Computed]
    public function jobs()
    {
        return JobVacancy::query()
            ->withCount('applications')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->jobLevelId, function ($query) {
                $query->where('job_level_id', $this->jobLevelId);
            })
            ->when($this->employeeTypeId, function ($query) {
                $query->where('employee_type_id', $this->employeeTypeId);
            })
            ->when($this->workTypeId, function ($query) {
                $query->where('work_type_id', $this->workTypeId);
            })
            ->with([
                'workType:id,name',
                'employeeType:id,name',
                'jobLevel:id,name',
            ])
            ->where('end_date', '>', \Carbon\Carbon::now())
            // ->where('status', true)
            ->latest()
            ->paginate(10);
    }

    #[Computed(cache: true, key: 'joblevels')]
    public function jobLevels()
    {
        return JobLevel::query()
            ->pluck('name', 'id');
    }

    #[Computed(cache: true, key: 'employeetypes')]
    public function employeeTypes()
    {
        return EmployeeType::query()
            ->pluck('name', 'id');
    }

    #[Computed(cache: true, key: 'worktypes')]
    public function workTypes()
    {
        return WorkType::query()
            ->pluck('name', 'id');
    }

    public function addRemoveJobVacancy(string $jobId): void
    {
        if (!Auth::check()) {
            $this->dispatch('notification', type: 'error', title: 'Gagal!', message: 'Silahkan login terlebih dahulu.', timeout: 1500);
        }
        $user = auth()->user();

        // cek sudah ada?
        $existing = JobVacancyBookmark::where('user_id', $user->id)
            ->where('job_vacancy_id', $jobId)
            ->first();

        if ($existing) {
            // hapus
            $existing->delete();
            $this->bookmarks = array_values(array_diff($this->bookmarks, [$jobId]));
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus penanda.', timeout: 1500);
        } else {
            // tambah (pakai create atau firstOrCreate untuk race-safety)
            JobVacancyBookmark::firstOrCreate([
                'user_id'        => $user->id,
                'job_vacancy_id' => $jobId,
            ]);
            $this->bookmarks[] = $jobId;
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menambahkan penanda.', timeout: 1500);
        }
    }

    public function render()
    {
        return view('livewire.frontend.jobs.jobs-index');
    }
}
