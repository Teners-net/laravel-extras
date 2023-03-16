# FileUploadTrait

This trait provides a set of methods that can be used to handle file uploading, validation, and storage. It can be added to any Laravel model that needs to handle file uploads.

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
            $validation_rules,
            'my_upload_path', // uses 'uploads' by defualt
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

```php
  ...
  $upload_result = $this->uploadFile(
      $request->file('file'),
      $validation_rules,
      'my_upload_path', // uses 'uploads' by defualt
      'public', // default value
      true, // saves to database
      $custum_model_instance // Your custom File model instance
  );
  ...
```

Publish the File model migration
```bash
php artisan vendor:publish --provider="Platinum\LaravelExtras\LaravelExtrasServiceProvider" --tag="migrations"
```