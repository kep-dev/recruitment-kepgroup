<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\{Computed, On};
use Illuminate\Support\Facades\Auth;
use App\Models\WorkExperience as Work;
use Illuminate\Validation\ValidationException;

class WorkExperience extends Component
{
    public User $user;
    public $user_id;
    public $job_title;
    public $company_name;
    public $job_position;
    public $industry;
    public $start_date;
    public $end_date;
    public $currently_working;
    public $description;

    public $workExperience;
    public $workExperienceId;

    public function deleteWorkExperience()
    {
        Work::find($this->workExperienceId)->delete();
        unset($this->workExperiences);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus pengalaman kerja.', timeout: 1500);
        $this->dispatch('closeModal');
    }

    #[On('updateWorkExperience')]
    public function userApplicant($id)
    {
        $this->workExperience = Work::find($id);

        $this->user_id = auth()->id();
        $this->job_title = $this->workExperience->job_title ?? null;
        $this->company_name = $this->workExperience->company_name ?? null;
        $this->job_position = $this->workExperience->job_position ?? null;
        $this->industry = $this->workExperience->industry ?? null;
        $this->start_date = $this->workExperience->start_date ?? null;
        $this->end_date = $this->workExperience->end_date ?? null;
        $this->currently_working = $this->workExperience->currently_working ?? null;
        $this->description = $this->workExperience->description ?? null;

    }

    public function updateWorkExperience()
    {
        try {
            $validated = $this->validate([
                'job_title' => 'required',
                'company_name' => 'required',
                'job_position' => 'required',
                'industry' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'currently_working' => 'nullable',
                'description' => 'required',
            ]);

            if ($this->workExperience) {
                $this->workExperience->updateOrCreate(
                    [
                        'user_id' => $this->user->id,
                    ],
                    [
                        'job_title' => $validated['job_title'],
                        'company_name' => $validated['company_name'],
                        'job_position' => $validated['job_position'],
                        'industry' => $validated['industry'],
                        'start_date' => $validated['start_date'],
                        'end_date' => $validated['end_date'],
                        'currently_working' => $validated['currently_working'],
                        'description' => $validated['description'],
                    ]
                );
            } else {
                Auth::user()->workExperiences()->create([
                    'job_title' => $validated['job_title'],
                    'company_name' => $validated['company_name'],
                    'job_position' => $validated['job_position'],
                    'industry' => $validated['industry'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'currently_working' => $validated['currently_working'],
                    'description' => $validated['description'],
                ]);
            }

            unset($this->workExperiences);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui pengalaman kerja.', timeout: 1500);
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function resetProperty()
    {
        $this->reset([
            'user_id',
            'job_title',
            'company_name',
            'job_position',
            'industry',
            'start_date',
            'end_date',
            'currently_working',
            'description',
            'workExperienceId'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function workExperiences()
    {
        return Work::query()
            ->orWhereBelongsTo(auth()->user())
            ->latest('start_date')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.work-experience');
    }
}
