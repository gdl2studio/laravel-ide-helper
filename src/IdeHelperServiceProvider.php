<?php

namespace Gdl2Studio\IdeHelper;

use Gdl2Studio\IdeHelper\Console\Commands\FacadesCommand;
use Illuminate\Support\ServiceProvider;

class IdeHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->runningInLocalConsoleEnv()) {
            $this->commands([
                FacadesCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        if ($this->runningInLocalConsoleEnv()) {
            $this->app->singleton('gdl2studio.laravel-ide-helper', function () {
                return new IdeHelper;
            });
        }
    }

    /**
     * Checks if running in local console environment.
     */
    protected function runningInLocalConsoleEnv(): bool
    {
        return $this->app->environment(['local', 'testing']) and $this->app->runningInConsole();
    }
}
