<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Livewire\Exam\{ExamIndex, ExamShow};
use App\Livewire\Frontend\Profile\ProfileIndex;
use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\Frontend\Dashboard\DashboardIndex;
use App\Livewire\Frontend\Jobs\{JobsIndex, JobsShow};
use App\Livewire\Frontend\Profile\Page\{SavedVacancy, MyApplication, MyProfile, MyTest};

Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

Route::group(
    [
        'middleware' => ['test_lock'],
    ],
    function () {
        Route::get('/', DashboardIndex::class)->name('frontend.dashboard');
        Route::get('/jobs', JobsIndex::class)->name('frontend.job');
        Route::get('/jobs/{JobVacancy:slug}', JobsShow::class)->name('frontend.job.show');
    }
);


Route::group(
    [
        'middleware' => ['auth', 'test_lock'],
        'prefix' => 'profile',
        'as' => 'frontend.'
    ],
    function () {
        Route::get('/', MyProfile::class)->name('profile');
        Route::get('/lamaran-saya', MyApplication::class)->name('profile.application');
        Route::get('/lowongan-tersimpan', SavedVacancy::class)->name('profile.saved-job');
        Route::get('/test-saya', MyTest::class)->name('profile.test');
    }
);

Route::group(
    [
        'middleware' => ['auth', 'test_lock'],
        'prefix' => 'exam',
        'as' => 'exam.'
    ],
    function () {
        Route::get('/{JobVacancyTest}', ExamIndex::class)->name('index');
        Route::get('/{attempt}/attempt', ExamShow::class)
            ->name('show')
            ->middleware('attempt_active')
            ->fallback(function () {
                return back()->with('error', 'Tidak dapat mengakses halaman ini.');
            });
    }
);

Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();
    $key  = 'resend-verif:'.$user->getAuthIdentifier();

    if (RateLimiter::tooManyAttempts($key, 1)) {
        // cukup kirim toast saja; GET nanti akan hitung sisa waktu
        $remaining = RateLimiter::availableIn($key);
        return back()->with('toast', ['type' => 'warning', 'text' => "Tunggu {$remaining} detik."]);
    }

    $user->sendEmailVerificationNotification();
    RateLimiter::hit($key, 60);

    return back()->with('toast', ['type' => 'info', 'text' => 'Link verifikasi dikirim.']);
})->middleware('auth')->name('verification.send');
