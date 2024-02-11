<?php

namespace Teners\LaravelExtras\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Teners\LaravelExtras\Models\File;

trait FileUploadTrait
{

    /**
     * Get default file system disk
     */
    protected function defaultDisk(): string
    {
        return config('filesystems.default', '');
    }

    /**
     * Validate a file based on the specified rules.
     *
     * @param UploadedFile $file
     *
     * @return array
     */
    public function validateFile(UploadedFile $file): array
    {
        $validator = Validator::make(['file' => $file], [
            'file' => 'required|file'
        ]);

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
        return uniqid('', true) . '_' . time() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Store a file in the specified disk.
     *
     * @param UploadedFile $file
     * @param string $file_name
     * @param string $path
     * @param string $disk
     *
     * @return array
     */
    public function storeFile(
        UploadedFile $file,
        string $file_name,
        $path = 'uploads',
        $disk = 'public'
    ) {
        try {
            $file->storeAs($path, $file_name, $disk);
        } catch (Exception $e) {
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
     *
     * @param string $file_path
     * @param string $file_name
     * @param float $file_size
     * @param string $disk
     * @param mixed $fileModel
     *
     * @return File
     */
    protected function storeFileInDatabase(
        string $file_path,
        string $file_name,
        float $file_size,
        $disk,
        $fileModel
    ) {
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
     * @param UploadedFile $file The file to store
     * @param string $filename The name of the file
     * @param string $path The storage path
     * @param string $disk What storage disk to use
     * @param bool $storeInDb Should the file be stored in the DB?
     *
     * @return object
     */
    public function uploadFile(
        UploadedFile $file,
        string $file_name = null,
        string $path = 'uploads',
        string $disk = null,
        bool $storeInDb = false,
        Model $model_instance = new File
    ) {

        $validation_result = $this->validateFile($file);
        if (!$validation_result['success']) {
            return $validation_result;
        }

        if (!$file_name) $file_name = $this->generateUniqueFileName($file);

        $store_result = $this->storeFile($file, $file_name, $path, $disk ?? $this->defaultDisk());
        if (!$store_result['success']) {
            return $store_result;
        }

        $file_path = "$path/$file_name";

        if ($storeInDb)
            $file_model = $this->storeFileInDatabase(
                $file_path,
                $file_name,
                $file->getSize(),
                $disk,
                $model_instance
            );

        else {
            $file_model = (object) [
                'path' => $file_path,
                'name' => $file_name,
                'size' => $file->getSize(),
                'disk' => $disk
            ];
        }

        return (object) [
            'success' => true,
            'file' => $file_model,
        ];
    }
}
