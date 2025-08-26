<?php

namespace App\Livewire\Frontend\Profile;

use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

#[Layout('components.layouts.app')]
#[Title('Profile')]
class ProfileIndex extends Component
{
    public function render()
    {
        return view('livewire.frontend.profile.profile-index');
    }
}
