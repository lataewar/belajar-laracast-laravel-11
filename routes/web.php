<?php

use App\Models\Job;
use App\Models\JobListing;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  dump(JobListing::all()->first()->title);
  return view('home');
});
Route::get('/contact', fn() => view('contact'));

Route::get('/jobs', fn() => view('jobs', [
  'jobs' => JobListing::all()
]));

Route::get('/jobs/{id}', function ($id) {
  return view('job', [
    'job' => JobListing::find($id)
  ]);
});
