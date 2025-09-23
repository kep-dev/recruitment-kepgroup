<?php

namespace App\Livewire\Frontend\Profile\Page;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, On, Computed};

#[Layout('components.layouts.profile')]
class MyApplication extends Component
{
    use WithPagination;
    public User $user;
    public $applicationId;

    public function mount()
    {
        $this->user = auth()->user();
    }

    #[On('cancel-apply')]
    public function getApplicationId($id)
    {
        $this->applicationId = $id;
    }

    public function cancelApplication()
    {
        $application = $this->user->applications()->find($this->applicationId);
        $application->delete();
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil membatalkan lamaran.', timeout: 1500);
    }

    #[Computed]
    public function applications()
    {
        return $this->user
            ->applications()
            ->latest()
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.frontend.profile.page.my-application');
    }
}
