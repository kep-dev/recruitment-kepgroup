<?php

namespace App\Livewire\Frontend\Profile;

use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

#[Layout('components.layouts.app')]
#[Title('Profile')]
class ProfileIndex extends Component
{

    public string $page = 'frontend.profile.page.my-profile';
    public $user;

    public $arrayPage = [
        'frontend.profile.page.my-profile' => 'Profil Saya',
        'frontend.profile.page.my-application' => 'Lamaran Saya',
    ];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.frontend.profile.profile-index');
    }
}
