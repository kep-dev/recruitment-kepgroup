<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, On};
use App\Traits\BlocksWhenActiveApplication;
use Illuminate\Validation\ValidationException;
use App\Models\TrainingCertification as ModelsTrainingCertification;

class TrainingCertification extends Component
{
    use BlocksWhenActiveApplication;

    public User $user;
    public $user_id;
    public $training_certification_title;
    public $institution_name;
    public $type;
    public $location;
    public $start_date;
    public $end_date;
    public $description;

    public $trainingCertification;
    public $trainingCertificationId;

    #[On('updateTrainingCertification')]
    public function userApplicant($id)
    {
        $this->trainingCertification = ModelsTrainingCertification::find($id);

        $this->user_id = auth()->id();
        $this->training_certification_title = $this->trainingCertification->training_certification_title ?? null;
        $this->institution_name = $this->trainingCertification->institution_name ?? null;
        $this->type = $this->trainingCertification->type ?? null;
        $this->location = $this->trainingCertification->location ?? null;
        $this->start_date = $this->trainingCertification->start_date ?? null;
        $this->end_date = $this->trainingCertification->end_date ?? null;
        $this->description = $this->trainingCertification->description ?? null;
    }

    public function updateTrainingCertification()
    {
        DB::beginTransaction();

        try {
            $validated = $this->validate([
                'training_certification_title' => 'required',
                'institution_name' => 'required',
                'type' => 'required',
                'location' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'description' => 'required',
            ]);

            $this->blockIfActive();

            if ($this->trainingCertification) {
                $this->trainingCertification->updateOrCreate(
                    [
                        'user_id' => $this->user->id,
                    ],
                    [
                        'training_certification_title' => $validated['training_certification_title'],
                        'institution_name' => $validated['institution_name'],
                        'type' => $validated['type'],
                        'location' => $validated['location'],
                        'start_date' => $validated['start_date'],
                        'end_date' => $validated['end_date'],
                        'description' => $validated['description'],
                    ]
                );
            } else {
                Auth::user()->trainingCertifications()->create([
                    'training_certification_title' => $validated['training_certification_title'],
                    'institution_name' => $validated['institution_name'],
                    'type' => $validated['type'],
                    'location' => $validated['location'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'description' => $validated['description'],
                ]);
            }

            DB::commit();
            unset($this->trainingCertifications);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui pelatihan dan sertifikasi.', timeout: 3000);
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

    public function deleteTrainingCertification()
    {
        DB::beginTransaction();

        try {
            $this->blockIfActive();
            ModelsTrainingCertification::find($this->trainingCertificationId)->delete();

            DB::commit();
            unset($this->trainingCertifications);
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus pelatihan dan sertifikasi.', timeout: 3000);
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
            'training_certification_title',
            'institution_name',
            'type',
            'location',
            'start_date',
            'end_date',
            'description'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function trainingCertifications()
    {
        return ModelsTrainingCertification::query()
            ->orWhereBelongsTo(auth()->user())
            ->latest('start_date')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.training-certification');
    }
}
