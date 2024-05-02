<?php

namespace Jobins\MagikaFileValidator;

use Illuminate\Support\ServiceProvider;

class MagikaFileValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/magika-file-validation.php' => config_path('magika-file-validator.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/magika-file-validation.php', 'magika-file-validator');
    }
}
