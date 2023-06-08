<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImageExtractor
{
  private $images = [];

  public function extractImages($filePath)
  {
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $drawingCollection = $worksheet->getDrawingCollection();

    foreach ($drawingCollection as $drawing) {
      if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
        $cellCoordinates = $drawing->getCoordinates();
        $cell = $worksheet->getCell($cellCoordinates);

        if ($cell->getValue() === null) {

          dd($cell);
          // $imageContents = $cell->getStyle()->getFill()->getStartColor()->getRGB();
          // $extension = $drawing->getExtension();

          // $this->images[] = [
          //   'name' => $drawing->getName(),
          //   'image' => base64_encode($imageContents),
          //   'extension' => $extension,
          // ];
        }
      }
    }

    return $this->images;
  }
}
