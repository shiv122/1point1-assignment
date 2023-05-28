<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements FromCollection, WithMapping, WithHeadings
{
  public $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function collection()
  {
    return new Collection($this->data);
  }
  public function map($data): array
  {
    return [
      $data->id,
      $data->name,
      $data->email,
      $data->dob,
      $data->gender,
      ($data->is_manager) ? 'yes' : 'no',
      $data->created_at,
    ];
  }
  public function headings(): array
  {
    return [
      'ID',
      'USER NAME',
      'EMAIL',
      'DATE OF BIRTH ',
      'GENDER ',
      'IS MANAGER ',
      'CREATED AT ',
    ];
  }
}
