<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
  public function create()
  {
    return view('auth.login');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', Password::min(6)],
    ]);

    if (!Auth::attempt($validated)) {
      throw ValidationException::withMessages([
        'email' => 'Sorry. those credentials do not match.'
      ]);
    }

    // regenerate the session token
    request()->session()->regenerate();

    return redirect('/');
  }

  public function destroy()
  {
    Auth::logout();

    return redirect('/');
  }
}
