<?php

namespace App\Livewire\Frontend\Jobs;

use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Lowongan')]
class JobsIndex extends Component
{
    public function render()
    {
        return view('livewire.frontend.jobs.jobs-index');
    }
}
