# FileUploadTrait

This trait provides a set of methods that can be used to handle file uploading, validation, and storage. It can be added to any Laravel model that needs to handle file uploads.

## Methods

**uploadFile()**
```php
uploadFile(
  UploadedFile $file,
  bool $storeInDb = false, 
  array $rules = [],
  string $path = 'uploads',
  string $disk = 'public',
  Model $model_instance = new File
): array
```

Uploads, validates and stores a file. Returns an array with a success key that indicates if the upload succeeded or failed, and a file key with the File model instance if the file was stored in the database. If storeInDb is set to false, the file key will be null.

## Usage
Add the FileUploadTrait and call the uploadFile() method from your controller to handle the file upload:
```php
use Platinum\LaravelExtras\Traits\FileUploadTrait;

class PostController extends Controller
{
    use FileUploadTrait;

    public function store(Request $request)
    {
        // Optional if you want to add more validation for the file
        $validation_rules = [
            'file' => 'max:1024',
        ];

        $upload_result = $this->uploadFile(
            $request->file('file'),
            false,
            $validation_rules,  // validation 'required|file' will also be applied
        );

        if ($upload_result['success']) {
            // File uploaded and stored in database
            $file_model = $upload_result['file'];
        } else {
            // Handle upload error
            $error_message = $upload_result['error'];
        }
    }
}
```

If you would like to store the details of the file uploaded the `Platinum\LaravelExtras\Models\File` model is used by default, but you can specify your own model.


Publish the migration
```bash
php artisan vendor:publish --provider="Platinum\LaravelExtras\LaravelExtrasServiceProvider" --tag="migrations"
```
and run `php artisan migrate`.

> Check here for more on the the [File](../models/file.md) model

```php
  ...
  $upload_result = $this->uploadFile(
      $request->file('file'),
      true, // saves to database
      [], // validation 'required|file' will still apply
      $custum_model_instance // Your custom File model instance
  );
  ...
```