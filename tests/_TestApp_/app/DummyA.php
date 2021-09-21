<?php

namespace TestApp;

use TestApp\Support\DummyB;

class DummyA extends DummyBase
{
    public function publicFnA(): void
    {
        // just another dummy function
    }

    public function returnsObject(): DummyB
    {
        return new DummyB();
    }

    protected function protectedFnA(): void
    {
        // just another dummy function
    }
}
