# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square)](https://packagist.org/packages/:vendor/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor/:package_name.svg?style=flat-square)](https://packagist.org/packages/:vendor/:package_name)
![GitHub Actions](https://github.com/:vendor/:package_name/actions/workflows/main.yml/badge.svg)

Custom file type validation for Laravel using magika

## Installation

You can install the package via composer:

```bash
composer require jobins/magika-file-validator
```

## Usage

```php
use Jobins\MagikaFileValidator\ValidateFileTypeRule;

$request->validate([
    'file' => [new ValidateFileTypeRule(['pdf', 'jpeg'])]
]);
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please use the issue tracker.

## Credits

-   [:Jobins](https://github.com/jobins)

## License

Please see [License File](LICENSE.md) for more information.
