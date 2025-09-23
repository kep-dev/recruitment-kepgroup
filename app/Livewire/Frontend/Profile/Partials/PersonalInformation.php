<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use App\Models\Applicant;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class PersonalInformation extends Component
{
    public User $user;
    public $applicant;
    public $name;
    public $nik;
    public $date_of_birth;
    public $gender;
    public $city;
    public $province;
    public $phone_number;

    #[On('openModal')]
    public function userApplicant($user_id)
    {
        $this->applicant = Applicant::query()
            ->where('user_id', $user_id)
            ->first();

        $this->name = $this->applicant->name ?? null;
        $this->nik = $this->applicant->nik ?? null;
        $this->date_of_birth = $this->applicant->date_of_birth ?? null;
        $this->gender = $this->applicant->gender ?? null;
        $this->city = $this->applicant->city ?? null;
        $this->province = $this->applicant->province ?? null;
        $this->phone_number = $this->applicant->phone_number ?? null;
    }

    public function updateApplicant()
    {
        // DB::transaction(function () {});

        try {
            $validated = $this->validate([
                // 'name' => 'required',
                'nik' => [
                    'required',
                    Rule::unique('applicants', 'nik')->ignore($this->applicant?->id)
                ],
                'date_of_birth' => 'required',
                'gender' => 'required',
                'city' => 'required',
                'province' => 'required',
                'phone_number' => [
                    'required',
                    Rule::unique('applicants', 'phone_number')->ignore($this->applicant?->id)
                ],
            ]);

            $this->user->applicant()->updateOrCreate(
                [
                    'user_id' => $this->user->id,
                ],
                [
                    // 'name' => $validated['name'],
                    'nik' => $validated['nik'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'gender' => $validated['gender'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'phone_number' => $validated['phone_number']
                ]
            );

            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui data diri.', timeout: 4500);
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 4500);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 4500);
        }
    }

    public function resetProperty()
    {
        $this->reset([
            'name',
            'nik',
            'date_of_birth',
            'gender',
            'city',
            'province',
            'phone_number'
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.personal-information');
    }
}
