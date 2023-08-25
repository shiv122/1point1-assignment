<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Managers\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserUpdateRequest;

class BasicController extends Controller
{
  public function index()
  {
    return view('content.pages.admin.tables.users');
  }

  public function store(UserRequest $request)
  {


    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'role' => $request->role,
    ]);



    return response([
      'status' => 'success',
      'message' => '<span class="text-success">' . $user->name . '</span> Added successfully',
      'refresh_table' => true,
    ]);
  }


  public function edit($id)
  {
    $employee = User::findOrFail($id);

    return response($employee);
  }


  public function update(UserUpdateRequest $request)
  {

    $user = User::find($request->id);

    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->role = $request->role;
    $request->password ? $user->password = bcrypt($request->password) : '';

    $user->save();

    return response([
      'status' => 'success',
      'message' => '<span class="text-success">' . $user->name . '</span> updated successfully',
      'refresh_table' => true,
    ]);
  }


  public function delete($id)
  {
    $emp = User::findOrFail($id);

    $emp->delete();

    return response([
      'status' => 'success',
      'refresh_table' => true,
    ]);
  }
}
