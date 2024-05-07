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
            __DIR__.'/../config/magika_src.php' => config_path('magika.php'),
        ]);

        $os = PHP_OS_FAMILY;
        $arch = php_uname('m');
        $folder = ($arch === 'x86_64') ? 'amd' : 'arm';

        switch ($os) {
            case 'Darwin':
                $binPath = __DIR__."/../bin/macos/{$folder}/magika";
                break;
            case 'Linux':
                $binPath = __DIR__ ."/../bin/linux/{$folder}/magika";
                break;
            default:
                Log::error("Unsupported operating system for magika binaries.");
                return;
        }

        $targetPath = storage_path('app/bin');
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        $this->publishes([
            $binPath => $targetPath . '/magika',
        ], 'binaries');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/magika.php', 'magika');
    }
}
