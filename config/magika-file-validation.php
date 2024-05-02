<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'magika_binary_path' => env('MAGIKA_BINARY_PATH', function () {
        switch (PHP_OS_FAMILY) {
            case 'Windows':
                return __DIR__.'/../bin/windows/magika.exe';
            case 'Darwin':
                return __DIR__.'/../bin/macos/magika';
            case 'Linux':
                return __DIR__.'/../bin/linux/magika';
            default:
                throw new \Exception("Unsupported operating system.");
        }
    })
];
