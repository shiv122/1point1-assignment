<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use App\Managers\FileManager;
use App\Imports\ImportEmployee;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

  public function bulkStore(Request $request, FileManager $fileManager)
  {
    $request->validate([
      'file' => 'required|file|mimes:csv,xlsx'
    ]);


    $sheet_path = $fileManager->upload($request->file, 'excel', 'emp-');

    $filePath = public_path($sheet_path);
    // Excel::import(new ImportEmployee, public_path('excel/excel-512569b99331b9e4f46ef72adcff409dbb8050618de.xlsx'));

    $spreadsheet = IOFactory::load($filePath);

    $drawingCollection = $spreadsheet->getActiveSheet()->getDrawingCollection();
    $worksheet = $spreadsheet->getActiveSheet();
    $images = [];
    $rows = [];
    $firstRow = [];

    foreach ($worksheet->getRowIterator() as $key =>  $row) {

      $rowData = [];
      $images = [];
      foreach ($row->getCellIterator() as $cell) {

        $drawingCollection = $cell->getWorksheet()->getDrawingCollection();
        if (!empty($drawingCollection)) {
          foreach ($drawingCollection as $drawing) {
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
              $imagePath = $drawing->getPath();
              $imageData = base64_encode(file_get_contents($imagePath));
              $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
              $images[] = [
                'name' => $drawing->getName(),
                'image' => $imageData,
                'extension' => $extension,
              ];
            }
          }
        }

        $rowData[] =  $cell->getValue();
      }
      if (empty($firstRow)) {
        $firstRow =  $rowData;
        continue;
      }
      $rows[] = [...array_combine($firstRow, $rowData), 'IMAGE' => $images[0] ?? null];
    }


    $insertData = [];

    foreach ($rows as $key => $row) {
      $insertData[] = [
        'name' => $row['NAME'],
        'email' => $row['EMAIL'],
        'dob' => $row['DOB'],
        'gender' => $row['GENDER'],
        'password' => bcrypt($row['PASSWORD']),
        'is_manager' => $row['IS_MANAGER'] === 'yes',
        'image' => ($row['IMAGE']) ? $this->saveBase64Image($row['IMAGE']['image'], $row['IMAGE']['extension']) : null,
        'role' => 'employee'
      ];
    }



    User::insert($insertData);

    return response([
      'status' => 'success',
      'message' => 'Employees added successfully',
      'refresh_table' => true,
    ]);
  }


  public function saveBase64Image($base64String, $extension)
  {



    $fileName = uniqid() . '.' . $extension;
    $pub_path = 'images/employee/profile' . $fileName;
    $filePath = public_path($pub_path);


    file_put_contents($filePath, base64_decode($base64String));

    return $pub_path;
  }
}
