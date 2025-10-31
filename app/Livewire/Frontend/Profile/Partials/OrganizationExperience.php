<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, On};
use App\Models\OrganizationalExperience;
use App\Traits\BlocksWhenActiveApplication;
use Illuminate\Validation\ValidationException;

class OrganizationExperience extends Component
{
    use BlocksWhenActiveApplication;

    public User $user;
    public $user_id;
    public $organization_name;
    public $position;
    public $level;
    public $start_date;
    public $end_date;

    public $organizationalExperience;
    public $organizationalExperienceId;

    #[Computed(persist: true, seconds: 7200)]
    public function organizationalExperiences()
    {
        return OrganizationalExperience::query()
            ->whereBelongsTo($this->user)
            ->latest('start_date')
            ->get();
    }

    #[On('updateOrganizationalExperience')]
    public function userApplicant($id)
    {
        $this->organizationalExperience = OrganizationalExperience::find($id);

        $this->user_id = auth()->id();
        $this->organization_name = $this->organizationalExperience->organization_name ?? null;
        $this->position = $this->organizationalExperience->position ?? null;
        $this->level = $this->organizationalExperience->level ?? null;
        $this->start_date = $this->organizationalExperience->start_date ?? null;
        $this->end_date = $this->organizationalExperience->end_date ?? null;
    }

    public function updateOrganizationalExperience()
    {
        DB::beginTransaction();

        try {
            $validated = $this->validate([
                'organization_name' => 'required',
                'position' => 'required',
                'level' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);

            $this->blockIfActive();

            if ($this->organizationalExperience) {
                $this->organizationalExperience->updateOrCreate(
                    [
                        'user_id' => $this->user->id,
                    ],
                    [
                        'organization_name' => $validated['organization_name'],
                        'position' => $validated['position'],
                        'level' => $validated['level'],
                        'start_date' => $validated['start_date'],
                        'end_date' => $validated['end_date'],
                    ]
                );
            } else {
                Auth::user()->organizationalExperiences()->create([
                    'organization_name' => $validated['organization_name'],
                    'position' => $validated['position'],
                    'level' => $validated['level'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                ]);
            }

            DB::commit();
            unset($this->organizationalExperiences);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui pengalaman organisasi.', timeout: 3000);
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteOrganizationalExperience()
    {
        DB::beginTransaction();

        try {
            $this->blockIfActive();
            OrganizationalExperience::find($this->organizationalExperienceId)->delete();

            DB::commit();
            unset($this->organizationalExperiences);
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus pengalaman organisasi.', timeout: 3000);
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
            'organization_name',
            'position',
            'level',
            'start_date',
            'end_date',
            'organizationalExperienceId'
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.organization-experience');
    }
}
