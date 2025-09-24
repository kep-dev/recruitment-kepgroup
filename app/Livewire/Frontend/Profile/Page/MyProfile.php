<?php

namespace App\Livewire\Frontend\Profile\Page;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Support\Facades\RateLimiter;

#[Layout('components.layouts.profile')]
#[Title('Profil Saya')]
class MyProfile extends Component
{
    public $user;

    public int $remaining = 0; // sisa detik cooldown

    public function mount(): void
    {
        $this->user = $user = Auth::user();
        abort_unless($user, 401);

        $key = $this->rateKey($user->getAuthIdentifier());
        $this->remaining = max(0, RateLimiter::availableIn($key));
    }

    public function resend(): void
    {
        $user = Auth::user();
        if (! $user) {
            $this->dispatch('toast', type: 'warning', message: 'Silakan login terlebih dahulu.');
            return;
        }

        $key = $this->rateKey($user->getAuthIdentifier());

        // Jika masih cooldown
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->remaining = max(1, RateLimiter::availableIn($key));
            // Beritahu Frontend untuk set countdown
            $this->dispatch('cooldown-set', remaining: $this->remaining);
            $this->dispatch('toast', type: 'warning', message: "Tunggu {$this->remaining} detik.");
            return;
        }

        // Kirim email verifikasi + set cooldown 60 detik
        $user->sendEmailVerificationNotification();
        RateLimiter::hit($key, 60);

        $this->remaining = max(0, RateLimiter::availableIn($key));
        $this->dispatch('cooldown-set', remaining: $this->remaining);
        $this->dispatch('toast', type: 'info', message: 'Link verifikasi dikirim.');
    }

    protected function rateKey(string $id): string
    {
        return 'resend-verif:' . $id;
    }

    public function render()
    {
        // dd($this->user);
        return view('livewire.frontend.profile.page.my-profile');
    }
}
