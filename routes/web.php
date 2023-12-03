<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
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

    Route::resource('schedules', ScheduleController::class);
    Route::resource('cities', CityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('applications', ApplicationController::class);
    Route::resource('jobs', JobController::class);
    Route::resource('users', UserController::class);

    Route::get('/job/{id}', [JobController::class, 'show'])->name('job');
    Route::get('/user/{id}/show-profile', [UserController::class, 'show'])->name('user');

    Route::post('/add-pdf', [UserController::class, 'addPdf'])->name('add.pdf');
    Route::post('/update-pdf', [UserController::class, 'updatePdf'])->name('update.pdf');
    Route::delete('/delete-pdf', [UserController::class, 'deletePdf'])->name('delete.pdf');
    Route::get('/download-pdf/{id}', [UserController::class, 'downloadPdf'])->name('download.pdf');


    Route::middleware(['role:user|company'])->group(function () {
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
    });

    Route::post('/send-request', [UserController::class, 'sendRequest'])->middleware(['role:user'])->name('sendRequest');
    Route::delete('/delete-request/{id}', [UserController::class, 'deleteRequest'])->middleware(['role:admin'])->name('deleteRequest');
});