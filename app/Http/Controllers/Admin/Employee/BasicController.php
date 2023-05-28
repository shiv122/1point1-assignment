<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use App\Managers\FileManager;
use App\Http\Controllers\Controller;
use App\Imports\ImportEmployee;
use Maatwebsite\Excel\Facades\Excel;

class BasicController extends Controller
{
  public function index()
  {
    return view('content.pages.admin.tables.employees');
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
      'is_manager' => 'required|in:yes,no',
    ]);

    $user = User::create([
      'name' => $request->username,
      'dob' => $request->dob,
      'gender' => $request->gender,
      'image' => $fileManager->upload($request->image, 'images/employee/profile'),
      'email' => $request->email,
      'is_manager' => ($request->is_manager === 'yes'),
      'password' => bcrypt($request->password),
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


  public function update(Request $request, FileManager $fileManager)
  {
    $request->validate([
      'id' => 'required|numeric',
      'username' => 'required|string|max:255',
      'email' => 'required|email|max:255|unique:users,email,' . $request->id,
      'password' => 'nullable|string|min:6',
      'dob' => 'required|date',
      'image' => 'nullable|file|max:512',
      'gender' => 'required|string|in:male,female,other',
      'is_manager' => 'required|in:yes,no',
    ]);


    $emp = User::findOrFail($request->id);

    $emp->name = $request->username;
    $emp->email = $request->email;
    $emp->dob  = $request->dob;
    $emp->gender  = $request->gender;
    $emp->is_manager  = ($request->is_manager === 'yes');
    if ($request->has('image')) {
      $emp->image  = $fileManager->upload($request->image, 'images/employee/profile');
    }
    if ($request->password) {
      $emp->password = bcrypt($request->password);
    }
    $emp->save();
    return response([
      'status' => 'success',
      'message' => '<span class="text-success">' . $emp->name . '</span> updated successfully',
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

  public function bulkStore(Request $request)
  {
    $request->validate([
      'file' => 'required|file|mimes:csv,xlsx'
    ]);


    Excel::import(new ImportEmployee, $request->file);


    return response([
      'status' => 'success',
      'message' => 'Employees added successfully',
      'refresh_table' => true,
    ]);
  }
}
