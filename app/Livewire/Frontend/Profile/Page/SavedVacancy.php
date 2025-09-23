<?php

namespace App\Livewire\Frontend\Profile\Page;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\JobVacancyBookmark;

#[Layout('components.layouts.profile')]
class SavedVacancy extends Component
{
    use WithPagination;
    public User $user;
    public array $applications = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->applications = auth()->user()?->applications()->pluck('job_vacancy_id')->toArray() ?? [];
    }

    #[Computed]
    public function savedVacancies()
    {
        return $this->user
            ->jobVacancyBookmarks()
            ->whereRelation('jobVacancy', [
                ['status', true],
                ['end_date', '>', Carbon::now()]
                ])
            ->latest()
            ->paginate(5);
    }

    public function removeBookmark($id)
    {
        $bookmark = JobVacancyBookmark::find($id);

        if ($bookmark) {
            $bookmark->delete();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus penanda.', timeout: 1500);
        }
    }

    public function render()
    {
        return view('livewire.frontend.profile.page.saved-vacancy');
    }
}
