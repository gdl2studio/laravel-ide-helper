<?php
SomeClass::{$method}(new \stdClass());
SomeClass::{'test'}(new \stdClass());

function example()
{
    SomeClass::{$method}(new \stdClass());
    SomeClass::{'test'}(new \stdClass());
}