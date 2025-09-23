<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use App\Models\Achievment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, On};
use Illuminate\Validation\ValidationException;

class Achievement extends Component
{
    public User $user;
    public $user_id;
    public $achievement_name;
    public $organization_name;
    public $year;

    public $achievement;
    public $achievementId;

    #[On('updateAchievement')]
    public function userApplicant($id)
    {
        $this->achievement = Achievment::find($id);

        $this->user_id = auth()->id();
        $this->achievement_name = $this->achievement->achievement_name ?? null;
        $this->organization_name = $this->achievement->organization_name ?? null;
        $this->year = $this->achievement->year ?? null;
    }

    public function updateAchievement()
    {
        try {
            $validated = $this->validate([
                'achievement_name' => 'required',
                'organization_name' => 'required',
                'year' => 'required|numeric|min:1900|max:' . date('Y'),
            ]);

            if ($this->achievement) {
                $this->achievement->updateOrCreate(
                    [
                        'user_id' => $this->user->id,
                    ],
                    [
                        'achievement_name' => $validated['achievement_name'],
                        'organization_name' => $validated['organization_name'],
                        'year' => $validated['year'],
                    ]
                );
            } else {
                Auth::user()->achievements()->create([
                    'achievement_name' => $validated['achievement_name'],
                    'organization_name' => $validated['organization_name'],
                    'year' => $validated['year'],
                ]);
            }

            unset($this->achievements);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui prestasi.', timeout: 1500);
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteAchievement()
    {
        Achievment::find($this->achievementId)->delete();
        unset($this->achievements);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus prestasi.', timeout: 1500);
        $this->dispatch('closeModal');
    }

    public function resetProperty()
    {
        $this->reset([
            'user_id',
            'achievement_name',
            'organization_name',
            'year'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function achievements()
    {
        return Achievment::query()
            ->where('user_id', Auth::user()->id)
            ->latest('year')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.achievement');
    }
}
