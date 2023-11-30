<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [JobController::class, 'dashboard'])->name('dashboard');
});

Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index')->name('jobs');
    Route::middleware(['auth'])->group(function () {
        Route::get('/job/{id}', 'show')->name('job');
    });
    // Route::middleware(['role:user'])->group(function () {
    //     Route::get('/job/{id}', 'show')->name('job');
    // });
});