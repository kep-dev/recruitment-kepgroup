<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use App\Models\Skill;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApplicantSkill extends Component
{
    public User $user;
    public $user_id;

    public $skill;

    public function updateSkill()
    {
        try {
            $validated = $this->validate([
                'skill' => [
                    'required',
                    Rule::unique('skills', 'skill')
                        ->where('user_id', Auth::user()->id)
                ],
            ]);

            Auth::user()->skills()->create([
                'skill' => $validated['skill'],
            ]);

            unset($this->skills);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui keahlian.', timeout: 1500);
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteSkill($id)
    {
        Skill::find($id)->delete();
        unset($this->skills);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus keahlian.', timeout: 1500);
        $this->dispatch('closeModal');
    }

    public function resetProperty()
    {
        $this->reset([
            'skill'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function skills()
    {
        return Skill::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.applicant-skill');
    }
}
