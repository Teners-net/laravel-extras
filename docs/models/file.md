# File Model
The File model is a simple model that represents a file in your Laravel application.
> This is the defualt model used with the [FileUploadTrait](../traits/file-upload-trait.md)


Publish the migration
```bash
php artisan vendor:publish --provider="Teners\LaravelExtras\LaravelExtrasServiceProvider" --tag="migrations"
```
and run `php artisan migrate`.

## Attributes
The File model has the following attributes:
- **id** : The primary key of the model.
- **path** : The path to the file in your storage disk.
- **name** : The name of the file.
- **size** : The size of the file in bytes.
- **disk** : The name of the storage disk where the file is located.

## Accessors
The model has two accessor attributes:
- **real_size** : Returns the file size in a human-readable format.
- **url** : Returns the URL to the file.

Example:
```php
  // Upload file using the FileUploadTrait in your controller
  ...
  $upload_result = $this->uploadFile(
      $request->file('file'),
      true, // saves to database
  );
  ...


  // Retrive the file
  $file = File::find(1);

  $url = $file->url;
  // {app_url}/public/storage/file_name.png

  $size = $file->real_size;
  // 2MB
```