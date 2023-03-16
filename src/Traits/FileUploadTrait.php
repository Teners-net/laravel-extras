<?php

namespace Platinum\LaravelExtras\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Platinum\LaravelExtras\Models\File;

trait FileUploadTrait
{
  /**
   * Validate a file based on the specified rules.
   *
   * @param UploadedFile $file
   * @param array $rules
   * @return array
   */
  public function validateFile(UploadedFile $file, array $rules): array
  {
    $validator = Validator::make(['file' => $file], $rules);

    if ($validator->fails()) {
      return [
        'success' => false,
        'error' => $validator->errors()->first(),
      ];
    }
    
    return [
      'success' => true,
    ];
  }

  /**
   * Generate a unique file name for a file.
   *
   * @param UploadedFile $file
   */
  public function generateUniqueFileName(UploadedFile $file): string
  {
    return uniqid('',true) . '_' . time() . '.' . $file->getClientOriginalExtension();
  }

  /**
   * Store a file in the specified disk.
   *
   * @param UploadedFile $file
   * @param string $file_name
   * @param string $path
   * @param string $disk
   */
  public function storeFile(
    UploadedFile $file, 
    string $file_name, 
    $path = 'uploads',
    $disk = 'public'): array
  {
    try {
        $file->storeAs($path, $file_name, $disk);
    }
    catch (Exception $e) {
        return [
          'success' => false,
          'error' => $e->getMessage(),
        ];
    }
    
    return [
      'success' => true,
    ];
  }

  /**
   * Store a file in the database.
   */
  private function storeFileInDatabase(
    string $file_path, 
    string $file_name, 
    float $file_size,
    $disk,
    $fileModel
    ): File
  {
    $file_model = $fileModel->create([
      'path' => $file_path,
      'name' => $file_name,
      'size' => $file_size,
      'disk' => $disk,
    ]);

    return $file_model;
  }


  /**
   * Upload, validate and store a file.
   *
   * @param UploadedFile $file
   * @param array $rules
   * @param string $path
   * @param string $disk
   */
  public function uploadFile(
    UploadedFile $file, 
    array $rules = [], 
    string $path = 'uploads',
    string $disk = 'public',
    bool $storeInDb = false,
    Model $model_instance = new File
    ): array
  {
    
    $validation_result = $this->validateFile($file, $rules);
    if (!$validation_result['success']) {
      return $validation_result;
    }

    $file_name = $this->generateUniqueFileName($file);
    
    $store_result = $this->storeFile($file, $file_name, $path, $disk);
    if (!$store_result['success']) {
      return $store_result;
    }

    $file_model = null;
    
    if ($storeInDb) {
      $file_path = "$path/$file_name";
      $file_model = $this->storeFileInDatabase($file_path, $file_name, $file->getSize(), $disk, $model_instance);
    }

    return [
      'success' => true,
      'file' => $file_model,
    ];
  }
}