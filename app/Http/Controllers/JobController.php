<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    JobListing::create([
      'title' => $request->title,
      'salary' => $request->salary,
      'employer_id' => 1,
    ]);

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
    if (Auth::guest()) {
      return redirect('/');
    }

    if ($job->employer->user->is(Auth::user())) {
      //
    }

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
