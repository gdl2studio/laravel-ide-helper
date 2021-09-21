<?php

namespace TestApp\Facades;

use Illuminate\Support\Facades\Facade;
use TestApp\Support\DummyB;

class DummyBFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DummyB::class;
    }
}
