<?php

use App\Livewire\Frontend\Dashboard\DashboardIndex;
use App\Livewire\Frontend\Profile\ProfileIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/profile', function () {
    return view('profile.profile');
});

Route::get('/', DashboardIndex::class)->name('frontend.dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', ProfileIndex::class)->name('frontend.profile');
});
