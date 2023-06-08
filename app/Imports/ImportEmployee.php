<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ImportEmployee implements ToModel, WithHeadingRow, WithEvents
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  protected $drawings = [];
  public function model(array $row)
  {

    // dd($row, $this->drawings);

    // return new User([
    //   'name'     => $row['name'],
    //   'email'    => $row['email'],
    //   'dob'    => $row['dob'],
    //   'gender'    => $row['gender'],
    //   'password'    => bcrypt($row['password']),
    //   'is_manager'    => ($row['is_manager'] === 'yes'),
    // ]);
  }
  public function headingRow(): int
  {
    return 1;
  }

  public function chunkSize(): int
  {
    return 1000;
  }

  public function registerEvents(): array
  {
    return [
      BeforeSheet::class => function (BeforeSheet $event) {
        $sheet = $event->sheet;
        dd($sheet);
        $spreadsheet = $sheet->getDelegate();
        $drawingCollection = $spreadsheet->getActiveSheet()->getDrawingCollection();

        foreach ($drawingCollection as $drawing) {
          if ($drawing instanceof Drawing) {
            $this->drawings[] = $drawing;
          }
        }
      },
    ];
  }

  public function getDrawings(): array
  {
    return $this->drawings;
  }
}
