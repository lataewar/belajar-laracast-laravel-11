<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
  // INDEX
  public function index()
  {
    return view('job.index', [
      'jobs' => JobListing::with('employer')->latest()->paginate(5)
      // 'jobs' => JobListing::with('employer')->simplePaginate(5)
      // 'jobs' => JobListing::with('employer')->cursorPaginate(5)
    ]);
  }

  // CREATE
  public function create()
  {
    return view('job.create');
  }

  // STORE
  public function store(Request $request)
  {
    $request->validate([
      'title' => ['required', 'min:3'],
      'salary' => ['required'],
    ]);

    $job = JobListing::create([
      'title' => $request->title,
      'salary' => $request->salary,
      'employer_id' => 1,
    ]);

    Mail::to($job->employer->user)->queue(new JobPosted($job));

    return redirect('/jobs');
  }

  // STORE
  public function show(JobListing $job)
  {
    return view('job.show', ['job' => $job]);
  }

  // EDIT
  public function edit(JobListing $job)
  {
    // abort_if($job->employer->user->isNot(Auth::user()), 403);

    // Gate::authorize('edit-job', $job);

    return view('job.edit', ['job' => $job]);
  }

  // UPDATE
  public function update(Request $request, JobListing $job)
  {
    $request->validate([
      'title' => ['required', 'min:3'],
      'salary' => ['required'],
    ]);

    $job->title = $request->title;
    $job->salary = $request->salary;
    $job->save();

    return redirect('/jobs/' . $job->id);
  }

  // DESTROY
  public function destroy(JobListing $job)
  {
    $job->delete();
    return redirect('/jobs');
  }
}
