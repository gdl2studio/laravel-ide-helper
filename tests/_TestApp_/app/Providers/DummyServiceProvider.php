<?php

namespace TestApp\Providers;

use Illuminate\Support\ServiceProvider;
use TestApp\DummyService;

class DummyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('test-app.dummy', function () {
            return new DummyService();
        });
    }

    public function boot()
    {
        // do nothing
    }
}
