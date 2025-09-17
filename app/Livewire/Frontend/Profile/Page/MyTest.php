<?php

namespace App\Livewire\Frontend\Profile\Page;

use App\Enums\status;
use Exception;
use Livewire\Component;
use App\Models\ApplicantTest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, Layout, Title};

#[Layout('components.layouts.profile')]
class MyTest extends Component
{
    public $token;

    #[Computed()]
    public function myTests()
    {
        return ApplicantTest::query()
            ->whereRelation('jobVacancyTest', 'is_active', true)
            ->whereRelation('application', 'user_id', auth()->user()->id)
            ->latest()
            ->get();
    }

    public function verifyToken()
    {
        DB::beginTransaction();

        try {
            $nowDb = DB::raw('CURRENT_TIMESTAMP');
            $applicantTest = ApplicantTest::query()
                ->where('access_token', $this->token)
                ->where(function ($q) {
                    $q->where('status', '!=', 'expired')
                        ->where('status', '!=', 'completed');
                })
                ->whereHas('jobVacancyTest', function ($q) use ($nowDb) {
                    $q->where('is_active', 1)
                        ->where(function ($q) use ($nowDb) {
                            $q->whereNull('active_from')
                                ->orWhere('active_from', '<=', $nowDb);
                        })
                        ->where(function ($q) use ($nowDb) {
                            $q->whereNull('active_until')
                                ->orWhere('active_until', '>=', $nowDb);
                        });
                    // ->whereNull('deleted_at'); // kalau pakai SoftDeletes
                })
                ->first();
            // dd($applicantTest);
            if (!$applicantTest) {
                throw new Exception('Token tidak valid / paket tidak aktif / anda sudah mengakhiri test');
            }

            $applicantTest->update([
                'started_at' => now(),
                'status' => status::in_progress,
            ]);

            session()->put('user_' . Auth::user()->id . '_token', $this->token);
            session()->put('jobVacancyTestId', $applicantTest->job_vacancy_test_id);
            DB::commit();
            return redirect()->route('exam.index', $applicantTest->job_vacancy_test_id);
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
            // $this->dispatch('closeModal');
        }
    }

    public function render()
    {
        // dd($this->myTests());
        return view('livewire.frontend.profile.page.my-test');
    }
}
