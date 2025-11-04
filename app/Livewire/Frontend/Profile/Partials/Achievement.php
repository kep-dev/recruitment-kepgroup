<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use App\Models\Achievment;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, On};
use App\Traits\BlocksWhenActiveApplication;
use Illuminate\Validation\ValidationException;

class Achievement extends Component
{
    use BlocksWhenActiveApplication;

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
        DB::beginTransaction();
        try {
            $validated = $this->validate([
                'achievement_name' => 'required',
                'organization_name' => 'required',
                'year' => 'required|numeric|min:1900|max:' . date('Y'),
            ]);

            // $this->blockIfActive();

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

            DB::commit();
            unset($this->achievements);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui prestasi.', timeout: 3000);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
        $this->dispatch('closeModal');
    }

    public function deleteAchievement()
    {
        DB::beginTransaction();
        try {
            // $this->blockIfActive();
            Achievment::find($this->achievementId)->delete();

            DB::commit();
            unset($this->achievements);
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus prestasi.', timeout: 3000);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }

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
