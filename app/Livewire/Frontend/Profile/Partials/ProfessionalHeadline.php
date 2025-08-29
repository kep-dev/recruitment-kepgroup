<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;

class ProfessionalHeadline extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.frontend.profile.partials.professional-headline');
    }
}
