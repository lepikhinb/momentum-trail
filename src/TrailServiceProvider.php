<?php

declare(strict_types=1);

namespace Momentum\Trail;

use Illuminate\Support\ServiceProvider;

class TrailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/trail.php', 'trail'
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateRoutesCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/trail.php' => config_path('trail.php'),
        ], 'trail-config');
    }
}
