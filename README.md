# Laravel Extras
Laravel Extras is a package that extend Laravel Application with more artisan commands and useful traits and helper classes.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/teners/laravel-extras.svg?style=flat-square)](https://packagist.org/packages/teners/laravel-extras)
[![issues](https://img.shields.io/github/issues/Teners-net/laravel-extras?style=flat-square)](https://github.com/Teners-net/laravel-extras/issues)
[![stars](https://img.shields.io/github/stars/Teners-net/laravel-extras?style=flat-square)](https://github.com/Teners-net/laravel-extras/issues)
[![GitHub license](https://img.shields.io/github/license/Teners-net/laravel-extras?style=flat-square)](https://github.com/Teners-net/laravel-extras/blob/main/LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/teners/laravel-extras.svg?style=flat-square)](https://packagist.org/packages/teners/laravel-extras)

## Installation
To install Laravel Extras, run the following command in your terminal:

```bash
composer require teners/laravel-extras
```

Publish the package configuration file
```bash
php artisan vendor:publish --provider="Teners\LaravelExtras\LaravelExtrasServiceProvider" --tag="config"
```

## Available Extras

Artisan Commands:
1. <a href="#make-blade">Make Blade</a> 
2. <a href="#make-trait">Make Trait</a>
3. <a href="#log-clear">Clear Log</a>

Extra Traits:
- [Sluggable](docs/traits/sluggable.md)
- [FileUploadTrait](docs/traits/file-upload-trait.md)

Extra Helpers:
- [FileGenerator](docs/helpers/file-generator.md)
- [ReadableValue](docs/helpers/readable-value.md)

Extra Models:
- [File](docs/models/file.md)


### Make Blade
Creates a **blade** file inside the **/resource/views/** directory.

``` bash
php artisan make:trait {name}
```

Example:
```bash
php artisan make:blade index
# or
php artisan make:blade user/index
```


### Make Trait
Creates a new Trait class in the **App/Traits** directory.

``` bash
php artisan make:trait {name}
```

Example:
``` bash
php artisan make:trait LocationTrait
# or
php artisan make:trait Security/LocationTrait
```

### Log Clear

Clears log data from **/storage/logs/** directory.

``` bash
php artisan log:clear
```


## Contributions
Contributions are **welcome** via Pull Requests on [Github](https://github.com/Teners-net/laravel-extras).
- Please document any change you made as neccesary in the [README.md](README.md).
- Pleas make only one pull request per feature/fix.
- See below for some ideas on what you can help with.
  - Option to generate file thumbnail in FileUploadTrait 
    - image/intervention for images, FFmeg for Videos
  - make:service
  - make:repository
  - contruct:with-values\
    Add and set public values in the contruct of files generated with other artisan commands, e.g: make:event, make:mail, make:notification
  - cast to slug\
    Extend Cast to provide 'slug' cast
  - MakeArrayTrait

## Issues
Please report any issue you encounter in using the package through the [Github Issues](https://github.com/Teners-net/laravel-extras/issues) tab.

## Testing

``` bash
composer test
```

## Credits

- [Emmanuel Adesina](https://github.com/ThePlatinum)

### Contributors

Contributors list will be added here

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


