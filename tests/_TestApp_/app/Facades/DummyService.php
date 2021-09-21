<?php

namespace TestApp\Facades;

use Illuminate\Support\Facades\Facade;

class DummyService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'test-app.dummy';
    }
}
