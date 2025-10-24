<?php

namespace App\Livewire\Frontend\Jobs;

use Livewire\Component;
use App\Models\JobVacancy;
use App\Models\Application;
use PhpParser\Node\Expr\Throw_;
use App\Models\JobVacancyBookmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Computed, Layout, Title};

#[Layout('components.layouts.app')]
#[Title('Detail Lowongan')]
class JobsShow extends Component
{
    public JobVacancy $JobVacancy;

    #[Computed()]
    public function applied()
    {
        return auth()->user()->applications()->where('job_vacancy_id', $this->JobVacancy->id)->exists();
    }

    #[Computed()]
    public function saved()
    {
        return auth()->user()->jobVacancyBookmarks()->where('job_vacancy_id', $this->JobVacancy->id)->exists();
    }

    public function apply($JobVacancyId)
    {
        DB::beginTransaction();

        try {
            if (!Auth::check()) {
                throw new \Exception('Silahkan login terlebih dahulu.');
            } else {
                if (! auth()->user()->hasVerifiedEmail()) {
                    // abort(403, 'Email Anda belum diverifikasi.');
                    throw new \Exception('Email Anda belum diverifikasi.');
                    // atau redirect:
                    // return redirect()->route('verification.notice');
                }

                $cooldownDays = (int) (DB::table('recruitment_policies')
                    ->where('key', 'reapply_cooldown_days')
                    ->value('value') ?? 180);

                $cutoff = now()->subDays($cooldownDays);

                // Blokir semua lamaran yang dibuat dalam 6 bulan terakhir (lintas lowongan)
                $exists = Application::query()
                    ->where('user_id', auth()->id())
                    ->where('created_at', '>=', $cutoff)
                    ->exists();

                if ($exists) {
                    $last = Application::where('user_id', auth()->id())
                        ->latest('created_at')->first();
                    $eligibleAt = $last->created_at->addDays($cooldownDays);
                    // abort(422, 'Anda baru bisa melamar lagi setelah ' . $eligibleAt->isoFormat('D MMM Y HH:mm'));
                    throw new \Exception('Anda baru bisa melamar lagi setelah ' . $eligibleAt->isoFormat('D MMM Y HH:mm'));
                }

                Auth::user()->applications()->create([
                    'job_vacancy_id' => $JobVacancyId,
                    'applied_at' => now(),
                ]);

                $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil mendaftar.', timeout: 3000);
                $this->dispatch('closeModal');
                unset($this->applied);
            }

            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            Log::error($th);
            $this->dispatch('notification', type: 'error', title: 'Gagal!', message: $th->getMessage(), timeout: 3000);
            $this->dispatch('closeModal');
        }
    }

    public function addRemoveJobVacancyBookmark(string $jobId): void
    {
        if (!Auth::check()) {
            $this->dispatch('notification', type: 'error', title: 'Gagal!', message: 'Silahkan login terlebih dahulu.', timeout: 1500);
        } else {
            $user = auth()->user();
            $existing = JobVacancyBookmark::where('user_id', $user->id)
                ->where('job_vacancy_id', $jobId)
                ->first();

            if ($this->saved) {
                // hapus
                $existing->delete();
                $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus penanda.', timeout: 1500);
            } else {
                // tambah (pakai create atau firstOrCreate untuk race-safety)
                JobVacancyBookmark::firstOrCreate([
                    'user_id'        => $user->id,
                    'job_vacancy_id' => $jobId,
                ]);
                $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menambahkan penanda.', timeout: 1500);
            }
            unset($this->saved);
        }
    }

    public function render()
    {
        return view('livewire.frontend.jobs.jobs-show');
    }
}
