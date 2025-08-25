<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/', function () {
    return view('index');
});
Route::get('/profile', function () {
    return view('profile.profile');
});
Route::get('/application', function () {
    return view('profile.application');
});
Route::get('/savedjob', function () {
    return view('appliprofile.savedjob');
});
Route::get('/setting', function () {
    return view('profile.setting');
});
