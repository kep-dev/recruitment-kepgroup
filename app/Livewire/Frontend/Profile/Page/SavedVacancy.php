<?php

namespace App\Livewire\Frontend\Profile\Page;

use App\Models\User;
use Livewire\Component;

class SavedVacancy extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.frontend.profile.page.saved-vacancy');
    }
}
