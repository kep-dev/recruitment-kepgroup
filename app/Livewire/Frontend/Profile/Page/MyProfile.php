<?php

namespace App\Livewire\Frontend\Profile\Page;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

#[Layout('components.layouts.profile')]
#[Title('Profil Saya')]
class MyProfile extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        // dd($this->user);
        return view('livewire.frontend.profile.page.my-profile');
    }
}
