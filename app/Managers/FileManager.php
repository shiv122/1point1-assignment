<?php

namespace App\Managers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileManager
{
  /**
   * Upload file  to local storage
   *
   * @param $file
   * @param $path
   * @param $type
   * @return string
   * @throws Exception
   *
   * This method is used to upload file to local storage (public folder)
   */

  public  function upload($file, string $path = "images", string $initials = "img"): string
  {
    try {
      $destinationPath =  $path;
      $req_file = $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension();
      $file = $file->move($destinationPath, $req_file);
      return  str_replace('\\', '/', $file);
    } catch (Exception  $e) {
      Log::info('Exception in image upload : ' . $e->getMessage());
      throw new Exception("Failed to upload image. error : " . $e->getMessage());
    }
  }


  /**
   *This method is used to upload file to Digital Ocean Spaces
   *
   * @param $file
   * @param string $path
   * @param string $initials
   * @return string
   * @throws Exception
   *
   * This function is used to upload file to s3 bucket of digital ocean
   */

  public  function uploadToDO($file, string $path = null, string $initials = "img"): string
  {
    $file_path = Storage::disk('do')
      ->putFileAs('public/' . $path ?? 'images/', $file, $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file
        ->getClientOriginalName());

    return Storage::disk('do')->url($file_path);
  }

  /**
   * @param $file
   * @param string $path
   * @param string $initials
   * @return string
   * @throws Exception
   *
   * This function is used to upload file to local storage
   */

  public function storeFile($file, $path = null, $initials = "img")
  {
    return Storage::disk('local')
      ->putFileAs('public/' . $path ?? 'images/', $file, $file
        ->getClientOriginalName());
  }

  //delete file from storage
  public static function deleteFile($file)
  {
    try {
      if (file_exists($file)) {
        unlink($file);
      }
    } catch (Exception $e) {
      Log::info('Exception in image delete : ' . $e->getMessage());
      throw new Exception("Failed to delete image. error : " . $e->getMessage());
    }
  }
}
