<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use App\Models\Education;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LatestEducation extends Component
{
    public User $user;
    public $user_id;
    public $education_level;
    public $major;
    public $university;
    public $location;
    public $graduation_year;
    public $gpa;
    public $education;

    public $educationId;

    #[On('updateEducation')]
    public function userApplicant($id)
    {
        $this->education = Education::find($id);

        $this->user_id = auth()->id();
        $this->education_level = $this->education->education_level ?? null;
        $this->major = $this->education->major ?? null;
        $this->university = $this->education->university ?? null;
        $this->location = $this->education->location ?? null;
        $this->graduation_year = $this->education->graduation_year ?? null;
        $this->gpa = $this->education->gpa ?? null;
    }

    public function updateEducation()
    {
        try {
            $validated = $this->validate([
                // 'name' => 'required',
                'education_level' => 'required|in:S3,S2,S1,D4,D3,D2,D1,SMA/Sederajat,SMP/Sederajat,SD/Sederajat',
                'major' => 'required',
                'university' => 'required',
                'location' => 'required',
                'graduation_year' => 'required|numeric|min:1900|max:' . date('Y'),
                'gpa' => 'required|numeric|min:0|max:10',
            ]);

            if ($this->education) {
                $this->education->updateOrCreate(
                    [
                        'user_id' => $this->user->id,
                    ],
                    [
                        'education_level' => $validated['education_level'],
                        'major' => $validated['major'],
                        'university' => $validated['university'],
                        'location' => $validated['location'],
                        'graduation_year' => $validated['graduation_year'],
                        'gpa' => $validated['gpa'],
                    ]
                );
            } else {
                Auth::user()->educations()->create([
                    'education_level' => $validated['education_level'],
                    'major' => $validated['major'],
                    'university' => $validated['university'],
                    'location' => $validated['location'],
                    'graduation_year' => $validated['graduation_year'],
                    'gpa' => $validated['gpa'],
                ]);
            }

            unset($this->educations);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui pendidikan terakhir.', timeout: 3000);
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteEducation()
    {
        Education::find($this->educationId)->delete();
        unset($this->educations);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus pendidikan terakhir.', timeout: 3000);
        $this->dispatch('closeModal');
    }

    public function resetProperty()
    {
        $this->reset([
            'user_id',
            'education_level',
            'major',
            'university',
            'location',
            'graduation_year',
            'gpa'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function educations()
    {
        return Education::query()
            ->orWhereBelongsTo(auth()->user())
            ->latest('graduation_year')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.latest-education');
    }
}
