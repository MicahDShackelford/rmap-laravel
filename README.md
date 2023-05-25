# External relationship mapping tool

[![Latest Version on Packagist](https://img.shields.io/packagist/v/micahdshackelford/rmap-laravel.svg?style=flat-square)](https://packagist.org/packages/micahdshackelford/rmap-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/micahdshackelford/rmap-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/micahdshackelford/rmap-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/micahdshackelford/rmap-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/micahdshackelford/rmap-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/micahdshackelford/rmap-laravel.svg?style=flat-square)](https://packagist.org/packages/micahdshackelford/rmap-laravel)

Adds the ability to specify external foreign keys in database migrations.

## Installation

You can install the package via composer:

```bash
composer require micahdshackelford/rmap-laravel
```

Register the service provider:

_in `config/app.php`_
```php
    'providers' => [
        ...
        /*
         * Package Service Providers...
         */
        MicahDShackelford\RmapLaravel\RmapLaravelServiceProvider::class,
        ...
    ]
```

Run the migration: `0000_00_00_000000_create_rmap_relationships_table.php`

## Usage

### Creating a foreign relationship (from migration)

1. Create a new migration: `php artisan make:migration [name] --create [table]`
2. Define an column & external foreign key relationship

```php
...
Schema::create('[table]', function (Blueprint $table) {
    ...
    $table->uuid('external_uuid');
    ...
    
    $table->externalForeign('test_uuid') // Name of the column on this table
        ->connection('external_connection') // External connection name
        ->on('tests') // External table
        ->references('uuid') // External column
        ->schema("default"); // (optional) Schema the external table.column lives on 
});
...
```

### Creating a foreign relationship (from command)

Use `php artisan rmap:create` and follow the prompts.

### Dropping a foreign relationship (from migration)

1. Create a roll migration: `php artisan make:migration [name] --table [table]`
2. Define an column & external foreign key relationship

```php
...
Schema::table('[table]', function (Blueprint $table) {
    $table->dropExternalForeign('test_uuid'); // Name of the column on this table
        // ->connection('external_connection') // (optional) External connection name
        // ->on('tests') // (optional) External table
        // ->references('uuid') // (optional) External column
        // ->schema("default"); // (optional) Schema the external table.column lives on 
});
...
```

### Clear all foreign relationships (from command)

Use `php artisan rmap:clear` and follow the prompts.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Micah Shackelford](https://github.com/MicahDShackelford)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
