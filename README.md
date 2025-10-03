# Flexible FilamentPHP plugin for SEO via a single JSON field, no extra tables, easy to use, fully adaptable.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inerba/filament-flexy-seo.svg?style=flat-square)](https://packagist.org/packages/inerba/filament-flexy-seo)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/inerba/filament-flexy-seo/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inerba/filament-flexy-seo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/inerba/filament-flexy-seo/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/inerba/filament-flexy-seo/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/inerba/filament-flexy-seo.svg?style=flat-square)](https://packagist.org/packages/inerba/filament-flexy-seo)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require inerba/filament-flexy-seo
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-flexy-seo-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-flexy-seo-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-flexy-seo-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

I campi si possono usare sia nelle Resource di FilamentPHP che nei Form di Livewire.


Nelle Form possiamo mettere i campi in questo modo:

```php
use Inerba\FilamentFlexySeo\Forms\Fields\Meta;

Meta::make('meta')
    ->label('SEO Meta Tags')
    ->description('Add SEO meta tags for this resource')
    ->required(),
```


Nelle resource bisogna prima preparare un campo json che ospiterà i dati

Nel nostro model:

```php
class Book extends Model
{
    protected $fillable = [
        // other fields
        'meta',
    ];

    protected $casts = [
        // other casts
        'meta' => 'array',
    ];

    // other model methods
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Francesco Apruzzese](https://github.com/inerba)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
