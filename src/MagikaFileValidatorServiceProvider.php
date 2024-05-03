<?php

namespace Jobins\MagikaFileValidator;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class MagikaFileValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/magika.php' => config_path('magika.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/magika.php', 'magika');
    }

    public static function postInstall()
    {
        $os = PHP_OS_FAMILY;

        switch ($os) {
            case 'Windows':
                $sourcePath = __DIR__.'/../bin/windows/magika.exe';
                break;
            case 'Darwin':
                $sourcePath = __DIR__.'/../bin/macos/magika';
                break;
            case 'Linux':
                $sourcePath = __DIR__.'/../bin/linux/magika';
                break;
            default:
                Log::error("Unsupported operating system for magika binaries.");

                return;
        }

        $destinationPath = storage_path('app/bin/magika');

        if (!file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0755, true);
        }

        copy($sourcePath, $destinationPath);
        chmod($destinationPath, 0755);

        echo "Installed binary for {$os} at {$destinationPath}\n";
    }
}
