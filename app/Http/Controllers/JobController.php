<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('job.index', [
      // 'jobs' => JobListing::all()
      'jobs' => JobListing::with('employer')->latest()->paginate(5)
      // 'jobs' => JobListing::with('employer')->simplePaginate(5)
      // 'jobs' => JobListing::with('employer')->cursorPaginate(5)
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('job.create');
  }

  /**
   * Store a newly created resource in storage.
   */
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

  /**
   * Display the specified resource.
   */
  public function show(JobListing $job)
  {
    return view('job.show', ['job' => $job]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(JobListing $job)
  {
    return view('job.edit', ['job' => $job]);
  }

  /**
   * Update the specified resource in storage.
   */
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

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(JobListing $job)
  {
    $job->delete();
    return redirect('/jobs');
  }
}
