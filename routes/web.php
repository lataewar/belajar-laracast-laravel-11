<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslateJob;
use App\Mail\JobPosted;
use App\Models\JobListing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/contact', 'contact');

// Route::resource('jobs', JobController::class);
Route::controller(JobController::class)->group(function () {
  Route::get('/jobs', 'index');
  Route::get('/jobs/create', 'create');
  Route::post('/jobs', 'store')->middleware('auth');
  Route::get('/jobs/{job}', 'show');
  // Route::get('/jobs/{job}/edit', 'edit')->middleware(['auth', 'can:edit-job,job']);
  Route::get('/jobs/{job}/edit', 'edit')->middleware(['auth'])->can('edit', 'job');
  Route::put('/jobs/{job}', 'update');
  Route::delete('/jobs/{job}', 'destroy');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('test', function () {
  $job = JobListing::first();

  // dispatch(function () {
  //   logger('hello from the queue!');
  // })->delay(5);
  TranslateJob::dispatch($job);

  return 'Done';
});
