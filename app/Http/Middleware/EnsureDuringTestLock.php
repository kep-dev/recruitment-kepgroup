<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDuringTestLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locked           = session('test_lock');
        $attemptId        = (string) session('test_attempt_id');
        $jobVacancyTestId = (string) session('jobVacancyTestId');
        $token = session('user_' . auth()?->user()?->id . '_token') ?? null;
        // dump($request->route('attempt')?->id);
        // Kalau tidak sedang tes → lanjutkan
        if (! $locked || ! $attemptId || ! $jobVacancyTestId || !$token) {
            return $next($request);
        }

        // 1) Izinkan halaman attempt aktif: route('exam.show', ['attempt' => {id}])
        if ($request->routeIs('exam.show') && (string) $request->route('attempt')->id == $attemptId) {
            return $next($request);
        }

        // 2) Izinkan index paket yang sesuai: route('exam.index', ['jobVacancyTest' => {id}])
        // Pastikan nama parameter rute-nya "jobVacancyTest" (lowercase)
        if (
            $request->routeIs('exam.index') &&
            $jobVacancyTestId !== '' &&
            (string) $request->route('JobVacancyTest')->id === $jobVacancyTestId
        ) {
            return $next($request);
        }

        // 3) (Opsional) izinkan API menjawab untuk attempt yang sama
        // if ($request->routeIs('exam.answer.*') && (string) $request->route('attempt') === $attemptId) {
        //     return $next($request);
        // }

        // Target redirect
        $targetUrl = route('exam.index', ['JobVacancyTest' => $jobVacancyTestId ?: $request->route('JobVacancyTest')->id]);

        // 4) Guard anti-loop: jika sudah di URL target, jangan redirect lagi
        if (url()->current() === $targetUrl) {
            // (opsional) lepas lock supaya tidak mantul
            // session()->forget(['test_lock', 'test_attempt_id', 'jobVacancyTestId']);
            return $next($request);
        }

        // Selain whitelist → kembalikan ke index paketnya
        return redirect()->to($targetUrl)
            ->with('test_alert', 'Anda harus menyelesaikan tes sebelum mengakses halaman lain.');
    }
}
