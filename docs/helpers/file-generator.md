# File Generator

This helper class provides a convenient way to generate files with a given content at a specified path.

## Usage
To use the FileGenerator class, you need to instantiate it with the required parameters:

```php 
use Teners\LaravelExtras\Helpers\FileGenerator;

// Instantiate the class
$fileGenerator = new FileGenerator(
    'path/to/file.txt', // path of the file to be created
    'file contents', // contents of the file to be createdexisting files
);

// Generate the file
$fileGenerator->generateFile(
  true // optional: set to `true` if you want to overwrite 
);
```

You can also use your own instance of Illuminate\Filesystem\Filesystem to generate the file:

```php
use Teners\LaravelExtras\Helpers\FileGenerator;
use Illuminate\Filesystem\Filesystem;

$filesystem = new Filesystem();

$fileGenerator = new FileGenerator(
    'path/to/file.txt',
    'file contents',
    $filesystem
);

$fileGenerator->generateFile(true);
```

### Overwriting Existing Files
By default, the FileGenerator class will not overwrite existing files. If you want to overwrite existing files, you can pass true as the second parameter to the generateFile() method:

```php
$fileGenerator = new FileGenerator(
    'path/to/file.txt',
    'file contents'
);

$fileGenerator->generateFile(); // throws an exception if file already exists

$fileGenerator->generateFile(true); // overwrites the file if it already exists
```