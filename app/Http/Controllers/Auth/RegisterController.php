<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Managers\FileManager;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function store(Request $request, FileManager $fileManager)
  {
    $request->validate([
      'username' => 'required|string|max:255',
      'email' => 'required|email|max:255|unique:users,email',
      'password' => 'required|string',
      'dob' => 'required|date',
      'image' => 'required|file|max:512',
      'gender' => 'required|string|in:male,female,other',
    ]);

    $user = User::create([
      'name' => $request->username,
      'dob' => $request->dob,
      'gender' => $request->gender,
      'image' => $fileManager->upload($request->image, 'images/employee/profile'),
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    Auth::login($user);

    return response([
      'status' => 'success',
      'message' => 'Hi ' . $user->name . ', Your Account registered successfully',
      'redirect' => route('employee.index'),
    ]);
  }
}
