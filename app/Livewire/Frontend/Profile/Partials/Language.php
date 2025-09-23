<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use App\Models\Language as ModelsLanguage;
use Illuminate\Validation\ValidationException;

class Language extends Component
{
    public User $user;
    public $user_id;
    public $language;
    public $level;

    public $languageObject;

    public function updateLanguage()
    {
        try {
            $validated = $this->validate([
                'language' => 'required',
                'level' => 'required',
            ]);

            Auth::user()->languages()->create([
                'language' => $validated['language'],
                'level' => $validated['level'],
            ]);

            unset($this->languages);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui bahasa.', timeout: 1500);
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteLanguage($id)
    {
        ModelsLanguage::find($id)->delete();
        unset($this->languages);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus bahasa.', timeout: 1500);
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
