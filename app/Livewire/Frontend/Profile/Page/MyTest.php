<?php

namespace App\Livewire\Frontend\Profile\Page;

use App\Enums\status;
use App\Models\ApplicantTest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class MyTest extends Component
{
    public $token;

    #[Url]
    public $type = null;

    #[Computed()]
    public function myTests()
    {
        return ApplicantTest::query()
            ->whereRelation('jobVacancyTest', [
                ['is_active', true],
                ['type', $this->type],
            ])
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
                ->whereNotIn('status', ['expired', 'completed'])
                ->whereHas('jobVacancyTest', function ($q) use ($nowDb) {
                    $q->where('is_active', 1)
                        ->where(fn ($q) => $q->whereNull('active_from')->orWhere('active_from', '<=', $nowDb))
                        ->where(fn ($q) => $q->whereNull('active_until')->orWhere('active_until', '>=', $nowDb));
                })
                ->first();

            if (! $applicantTest) {
                throw new Exception('Token tidak valid / paket tidak aktif / anda sudah mengakhiri tes.');
            }

            // Single-session gate (lihat bagian #3 untuk kolom/middleware)
            $sessionId = session()->getId();
            $applicantTest->forceFill([
                'started_at' => $applicantTest->started_at ?? now(),
                'status' => Status::in_progress,
                'current_session_id' => $sessionId, // kolom baru (lihat migrasi #3)
            ])->save();

            session()->put('user_'.Auth::id().'_token', $this->token);
            session()->put('jobVacancyTestId', $applicantTest->job_vacancy_test_id);

            DB::commit();

            // >>> KUNCI: kirim event untuk dibuka di TAB BARU + fullscreen
            $url = route('exam.index', $applicantTest->job_vacancy_test_id);
            $this->dispatch('open-exam-tab', url: $url);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function render()
    {
        // dd($this->myTests());
        return view('livewire.frontend.profile.page.my-test');
    }
}
