<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use App\Models\Salary;
use Livewire\Component;
use Livewire\Attributes\{Computed, On};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApplicantSalary extends Component
{
    public User $user;
    public $user_id;
    public $expected_salary;
    public $current_salary;

    #[On('updateSalary')]
    public function getSalary($id)
    {
        $salary = Salary::find($id);
        $this->expected_salary = $salary->expected_salary;
        $this->current_salary = $salary->current_salary;
    }

    public function updateSalary()
    {
        try {
            $validated = $this->validate([
                'expected_salary' => 'nullable|numeric',
                'current_salary' => 'nullable|numeric',
            ]);

            Auth::user()->salary()->updateOrCreate([
                'user_id' => Auth::user()->id
            ], [
                'expected_salary' => $validated['expected_salary'],
                'current_salary' => $validated['current_salary'],
            ]);

            unset($this->salary);
            $this->resetProperty();
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui gaji.', timeout: 1500);
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteSalary($id)
    {
        Salary::find($id)->delete();
        unset($this->salary);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus gaji.', timeout: 1500);
        $this->dispatch('closeModal');
    }

    public function resetProperty()
    {
        $this->reset([
            'expected_salary',
            'current_salary'
        ]);
    }

    #[Computed(persist: true, seconds: 7200)]
    public function salary()
    {
        return Salary::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->first();
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.applicant-salary');
    }
}
