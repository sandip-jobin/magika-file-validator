<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'magika_binary_path' => env('MAGIKA_BINARY_PATH', function () {
        $arch   = php_uname('m');
        $folder = ($arch === 'x86_64') ? 'amd' : 'arm';

        switch (PHP_OS_FAMILY) {
            case 'Darwin':
                return __DIR__."/../bin/macos/{$folder}/magika";
            case 'Linux':
                return __DIR__."/../bin/linux/{$folder}/magika";
            default:
                throw new \Exception("Unsupported operating system.");
        }
    })
];
