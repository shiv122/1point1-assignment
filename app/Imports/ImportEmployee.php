<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportEmployee implements ToModel
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {

    return new User([
      'name'     => $row[0],
      'email'    => $row[1],
      'dob'    => $row[2],
      'gender'    => $row[3],
      'password'    => bcrypt($row[4]),
      'is_manager'    => ($row[5] === 'yes'),
    ]);
  }

  public function chunkSize(): int
  {
    return 1000;
  }
}
