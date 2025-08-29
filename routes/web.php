<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Livewire\Frontend\Jobs\JobsIndex;
use App\Livewire\Frontend\Profile\ProfileIndex;
use App\Livewire\Frontend\Dashboard\DashboardIndex;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/profile', function () {
    return view('profile.profile');
});

Route::get('/', DashboardIndex::class)->name('frontend.dashboard');
Route::get('/jobs', JobsIndex::class)->name('frontend.job');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', ProfileIndex::class)->name('frontend.profile');
});
