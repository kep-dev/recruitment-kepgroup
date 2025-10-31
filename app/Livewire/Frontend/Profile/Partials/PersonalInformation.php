<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Applicant;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use App\Traits\BlocksWhenActiveApplication;
use Illuminate\Validation\ValidationException;

class PersonalInformation extends Component
{
    use WithFileUploads, BlocksWhenActiveApplication;

    public User $user;
    public $applicant;
    public $name;
    public $nik;
    public $date_of_birth;
    public $place_of_birth;
    public $gender;
    public $phone_number;
    public $address_line;
    public $postal_code;
    public $village_code;

    public $provinceId, $regencyId, $districtId;
    public array $provinces;

    #[Validate('nullable|image|mimes:jpeg,png|max:2048')] // 2048 KB = 2 MB
    public $photo;

    #[On('openModal')]
    public function userApplicant($user_id)
    {
        $this->applicant = Applicant::query()
            ->where('user_id', $user_id)
            ->first();

        $this->name = $this->applicant->name ?? null;
        $this->nik = $this->applicant->nik ?? null;
        $this->date_of_birth = $this->applicant->date_of_birth ?? null;
        $this->place_of_birth = $this->applicant->place_of_birth ?? null;
        $this->gender = $this->applicant->gender ?? null;
        $this->phone_number = $this->applicant->phone_number ?? null;
        $this->address_line = $this->applicant->address_line ?? null;
        $this->postal_code = $this->applicant->postal_code ?? null;
        $this->village_code = $this->applicant->village_code ?? null;
        $this->provinceId = $this->applicant->province->code ?? null;
        $this->regencyId = $this->applicant->regency->code ?? null;
        $this->districtId = $this->applicant->district->code ?? null;

        $this->provinces = Province::query()
            ->orderBy('name')
            ->pluck('name', 'code')
            ->toArray();
    }

    #[Computed()]
    public function regencies()
    {
        return $this->provinceId ?
            Regency::query()
            ->where('province_code', $this->provinceId)
            ->orderBy('name')
            ->pluck('name', 'code') : [];
    }

    #[Computed()]
    public function districts()
    {
        return $this->regencyId ?
            District::query()
            ->where('regency_code', $this->regencyId)
            ->orderBy('name')
            ->pluck('name', 'code') : [];
    }

    #[Computed()]
    public function villages()
    {
        return $this->districtId ?
            Village::query()
            ->where('district_code', $this->districtId)
            ->orderBy('name')
            ->pluck('name', 'code') : [];
    }

    public function updateApplicant()
    {
        DB::beginTransaction();

        try {
            $validated = $this->validate([
                'nik' => [
                    'required',
                    Rule::unique('applicants', 'nik')->ignore($this->applicant?->id)
                ],
                'date_of_birth' => 'required',
                'place_of_birth' => 'required',
                'gender' => 'required',
                'phone_number' => [
                    'required',
                    Rule::unique('applicants', 'phone_number')->ignore($this->applicant?->id)
                ],
                'address_line' => 'required',
                'postal_code' => 'required|numeric',
                'village_code' => 'required|exists:villages,code'
            ]);

            $this->blockIfActive();

            $this->user->applicant()->updateOrCreate(
                [
                    'user_id' => $this->user->id,
                ],
                [
                    // 'name' => $validated['name'],
                    'nik' => $validated['nik'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'place_of_birth' => $validated['place_of_birth'],
                    'gender' => $validated['gender'],
                    'phone_number' => $validated['phone_number'],
                    'address_line' => $validated['address_line'],
                    'postal_code' => $validated['postal_code'],
                    'village_code' => $validated['village_code'],
                ]
            );

            if ($this->photo) {
                if ($this->user->applicant->photo) {
                    Storage::disk('public')->delete($this->user->applicant->photo);
                }

                $this->user->applicant()->update([
                    'photo' => Storage::disk('public')->putFile('applicants', $this->photo)
                ]);
            }

            DB::commit();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui data diri.', timeout: 4500);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 4500);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 4500);
        }
        $this->dispatch('closeModal');
    }

    public function resetProperty()
    {
        $this->reset([
            'name',
            'nik',
            'date_of_birth',
            'place_of_birth',
            'gender',
            'phone_number',
            'address_line',
            'postal_code',
            'village_code'
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.personal-information');
    }
}
