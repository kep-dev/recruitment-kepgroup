<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use App\Models\SocialMedia;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApplicantSocialMedia extends Component
{
    public User $user;
    public $user_id;
    public $name;
    public $url;

    public function updateSocialMedia()
    {
        try {
            $validated = $this->validate([
                'name' => [
                    'required',
                    'string',
                    Rule::unique('social_medias')
                        ->where('user_id', Auth::user()->id)
                ],
                'url' => [
                    'required',
                    'string',
                    Rule::unique('social_medias')
                        ->where('user_id', Auth::user()->id)
                ],
            ]);

            Auth::user()->socialMedias()->create([
                'name' => $validated['name'],
                'url' => $validated['url'],
            ]);

            unset($this->socialMedias);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui media sosial.', timeout: 1500);
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteSocialMedia($id)
    {
        SocialMedia::find($id)->delete();
        unset($this->socialMedias);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus media sosial.', timeout: 1500);
        $this->dispatch('closeModal');
    }

    public function resetProperty()
    {
        $this->reset([
            'name',
            'url'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function socialMedias()
    {
        return SocialMedia::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.applicant-social-media');
    }
}
