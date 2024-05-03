# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sandip-jobin/magika-file-validator.svg?style=flat-square)](https://packagist.org/packages/sandip-jobin/magika-file-validator)
[![Total Downloads](https://img.shields.io/packagist/dt/sandip-jobin/magika-file-validator.svg?style=flat-square)](https://packagist.org/packages/sandip-jobin/magika-file-validator)

Custom file type validation for Laravel using magika

## Installation

You can install the package via composer:

```bash
composer require sandip-jobin/magika-file-validator
```

## Usage

```php
use Jobins\MagikaFileValidator\Rules\MagikaFileTypeValidationRule;

$request->validate([
    'file' => [new MagikaFileTypeValidationRule(['pdf', 'jpeg'])]
]);
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please use the issue tracker.

## Credits

-   [Jobins](https://github.com/jobins)

## License

Please see [License File](LICENSE.md) for more information.
