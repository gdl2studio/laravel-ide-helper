<?php

// some comment

/*
 * some other comment
 */

namespace TestApp\Support;

/*
// some comment
 * some other comment
 */

// this is comment too .,,,

use TestApp\DummyBase;

// just use it

/**
 *  This is a DummyB class annotation.
 *
 *  this class helps do things
 */
class DummyB extends DummyBase
{
    private string $var = '/* this is not a comment*/';

    public function functionB() // this is a method comment
    {
    }
}
