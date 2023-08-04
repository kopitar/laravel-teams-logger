<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger;

use Illuminate\Support\ServiceProvider;

class TeamsLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/teams_logger.php', 'teams'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/teams_logger.php' => config_path('teams_logger.php'),
        ], 'teams');
    }
}
