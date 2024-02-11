# FileUploadTrait

This trait provides a set of methods that can be used to handle file uploading, and storage. It can be added to any Laravel model that needs to handle file uploads.

## Methods

**uploadFile()**
```php
uploadFile(
  UploadedFile $file,
  string $file_name = null,
  string $path = 'uploads',
  string $disk,
  bool $storeInDb = false,
  Model $model_instance = new File
)
```

Uploads, validates and stores a file. Returns an object with a `success` that indicates if the upload succeeded or failed, and a `file` with the File model instance if the file was stored in the database or file details object if not stored in database.

> If `$storeInDb` is set to false, the file key will be an array of the file details.
> If the `$file_name` is not set, a unique name is generated for the file

## Usage
Add the FileUploadTrait and call the uploadFile() method from your controller to handle the file upload:
```php
use Teners\LaravelExtras\Traits\FileUploadTrait;

class PostController extends Controller
{
    use FileUploadTrait;

    public function store(Request $request)
    {
        $upload_result = $this->uploadFile(
            $request->file('file')
        );

        if ($upload_result->success) {
            // File uploaded and stored in database
            $file_model = $upload_result->file;
        } else {
            // Handle upload error
        }
    }
}
```

If you would like to store the details of the file uploaded the `Teners\LaravelExtras\Models\File` model is used by default, but you can specify your own model.


Publish the migration
```bash
php artisan vendor:publish --provider="Teners\LaravelExtras\LaravelExtrasServiceProvider" --tag="migrations"
```
and run `php artisan migrate`.

> Check here for more on the the [File](../models/file.md) model

```php
  ...
  $upload_result = $this->uploadFile(
      $request->file('file'),
      ...
      true, // saves to database
      $custum_model_instance // Your custom File model instance
  );
  ...
```


You can override the 
- __storeFileInDatabase()__
- __storeFileInDatabase()__