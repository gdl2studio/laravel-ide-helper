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
            // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'idehelper');
            // $this->publishes([ __DIR__.'/../config/config.php' => config_path('idehelper.php') ], 'config');

             $this->commands([
                 FacadesCommand::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        if ($this->runningInLocalConsoleEnv()) {
            // Automatically apply the package configuration
            // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'idehelper');

            $this->app->singleton('gdl2studio.ide-helper', function () {
                return new IdeHelper;
            });
        }
    }

    /**
     * Checks if running in local console environment
     */
    protected function runningInLocalConsoleEnv(): bool
    {
        return $this->app->environment(['local', 'testing']) and $this->app->runningInConsole();
    }
}
