<?php

namespace TestApp;

use Illuminate\Support\Facades\Facade;

/**
 **
 * This is a DummyAFacade class annotation
 * this class helps do things using DummyA class.
 */
class DummyAFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DummyA::class;
    }
}
