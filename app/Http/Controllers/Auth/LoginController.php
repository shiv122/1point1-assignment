<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'email' => 'required|string|email|max:255',
      'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    if (!auth()->attempt($credentials, $request->remember_me)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }


    $request->session()->regenerate();

    return response()->json([
      'message' => 'Successfully logged in',
      'redirect' => route('admin.index'),
    ]);
  }



  public function logout(Request $request)
  {
    Session::flush();

    Auth::logout();

    return redirect()->route('auth.login.index');
  }
}
