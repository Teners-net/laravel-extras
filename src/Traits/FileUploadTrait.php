<?php

namespace Teners\LaravelExtras\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Teners\LaravelExtras\Models\File;

trait FileUploadTrait
{
    protected array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'application/pdf',
        'text/plain',
        'application/msword'
    ];

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
            'file' => [
                'required',
                'file',
                Rule::in($this->allowedMimeTypes),
            ]
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors()->first(),
            ];
        }

        return ['success' => true];
    }

    /**
     * Generate a unique file name for a file.
     *
     * @param UploadedFile $file
     */
    public function generateUniqueFileName(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);

        return $safeName . '_' . uniqid() . '_' . time() . '.' . $extension;
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
        array $fileData,
        $fileModel
    ) {
        return $fileModel->create($fileData);
    }

    /**
     * Upload, validate and store a file.
     *
     * @param UploadedFile $file The file to upload
     * @param string|null $fileName Custom filename (optional)
     * @param string $path Storage path relative to disk root
     * @param string|null $disk Storage disk name
     * @param bool $storeInDb Whether to save file info to database
     * @param Model $modelInstance Model instance for database storage
     *
     * @return object Result object with success status and file info
     * @throws Exception When file upload fails
     * @throws ValidationException When file validation fails
     */
    public function uploadFile(
        UploadedFile $file,
        ?string $file_name = null,
        string $path = 'uploads',
        ?string $disk = null,
        bool $storeInDb = false,
        Model $modelIstance = new File
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

        $fileData = [
            'path' => "$path/$file_name",
            'name' => $file_name,
            'size' => $file->getSize(),
            'extension' => $file->extension(),
            'disk' => $disk
        ];

        $file_model = ($storeInDb) ?
            $this->storeFileInDatabase($fileData, $modelIstance) :
            (object) $fileData;

        return (object) [
            'success' => true,
            'file' => $file_model,
        ];
    }
}
