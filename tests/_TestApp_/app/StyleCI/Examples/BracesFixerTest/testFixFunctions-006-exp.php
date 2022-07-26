<?php
    foo(array_map(function ($object) use ($x, $y)
    {
        return array_filter($object->bar(), function ($o)
        {
            return $o->isBaz();
        });
    }, $collection));