<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use App\Models\Skill;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\BlocksWhenActiveApplication;
use Illuminate\Validation\ValidationException;

class ApplicantSkill extends Component
{
    use BlocksWhenActiveApplication;

    public User $user;
    public $user_id;

    public $skill;

    public function updateSkill()
    {
        DB::beginTransaction();

        try {
            $validated = $this->validate([
                'skill' => [
                    'required',
                    Rule::unique('skills', 'skill')
                        ->where('user_id', Auth::user()->id)
                ],
            ]);

            // $this->blockIfActive();

            Auth::user()->skills()->create([
                'skill' => $validated['skill'],
            ]);

            DB::commit();
            unset($this->skills);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui keahlian.', timeout: 3000);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteSkill($id)
    {
        DB::beginTransaction();

        try {
            // $this->blockIfActive();
            Skill::find($id)->delete();

            DB::commit();
            unset($this->skills);
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus keahlian.', timeout: 3000);
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
