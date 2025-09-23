<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EnsureAttemptActive
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $paramName  Nama parameter route untuk attempt id (default: "attempt")
     */
    public function handle(Request $request, Closure $next)
    {
        $attemptId = $request->route('attempt')->id;
        if (!$attemptId) {
            abort(404); // tidak ada attempt id di route
        }

        // Ambil attempt
        $attempt = DB::table('applicant_test_attempts')->where('id', $attemptId)->first();
        if (!$attempt) {
            abort(404);
        }

        // (Opsional) Cek kepemilikan attempt terhadap user login (kalau tes memerlukan login)
        // $applicantTest = DB::table('applicant_tests')->where('id', $attempt->applicant_test_id)->first();
        // if ($applicantTest->application_user_id !== auth()->id()) { abort(403); }

        // 1) Auto-expire jika sudah melewati deadline
        if ($attempt->status === 'in_progress' && $attempt->deadline_at) {
            if (now()->greaterThan(Carbon::parse($attempt->deadline_at))) {
                DB::table('applicant_test_attempts')
                    ->where('id', $attempt->id)
                    ->update([
                        'status'       => 'expired',
                        'ended_reason' => 'timeout',
                        'updated_at'   => now(),
                    ]);

                return $this->deny($request, 'Waktu tes telah habis.');
            }
        }

        // 2) Blokir jika bukan status aktif
        if (in_array($attempt->status, ['submitted', 'graded', 'expired'], true)) {
            return $this->deny($request, 'Tes ini sudah tidak bisa diakses.');
        }

        // 3) (Opsional) Blokir jika paket sudah di luar window aktif
        // $vt = DB::table('job_vacancy_tests as vt')
        //     ->join('applicant_tests as at','at.job_vacancy_test_id','=','vt.id')
        //     ->where('at.id',$attempt->applicant_test_id)
        //     ->select('vt.active_from','vt.active_until','vt.is_active')
        //     ->first();
        // if (!$vt->is_active || ($vt->active_from && now()->lt($vt->active_from)) || ($vt->active_until && now()->gt($vt->active_until))) {
        //     return $this->deny($request, 'Paket tes tidak aktif.');
        // }

        return $next($request);
    }

    private function deny(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 423); // 423 Locked
        }

        // Simpan flash agar bisa ditampilkan di UI
        return redirect()->back()->with('test_alert', $message);
    }
}
