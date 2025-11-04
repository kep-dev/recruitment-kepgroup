<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Language as ModelsLanguage;
use App\Traits\BlocksWhenActiveApplication;
use Illuminate\Validation\ValidationException;

class Language extends Component
{
    use BlocksWhenActiveApplication;

    public User $user;
    public $user_id;
    public $language;
    public $level;

    public $languageObject;

    public function updateLanguage()
    {
        DB::beginTransaction();

        try {
            $validated = $this->validate([
                'language' => 'required',
                'level' => 'required',
            ]);

            // $this->blockIfActive();
            $user = $this->user;

            $user->languages()->create([
                'language' => $validated['language'],
                'level' => $validated['level'],
            ]);

            DB::commit();
            unset($this->languages);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui bahasa.', timeout: 3000);
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

    public function deleteLanguage($id)
    {
        DB::beginTransaction();
        try {
            // $this->blockIfActive();
            ModelsLanguage::find($id)->delete();

            DB::commit();
            unset($this->languages);
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus bahasa.', timeout: 3000);
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
            'language',
            'level'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function languages()
    {
        return ModelsLanguage::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.language');
    }
}
