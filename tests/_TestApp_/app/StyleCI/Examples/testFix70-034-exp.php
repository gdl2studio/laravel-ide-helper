<?php
    $a = function (int $foo): string
    {
        echo $foo;
    };

    $b = function (int $foo) use ($bar): string
    {
        echo $foo . $bar;
    };

    function a() {
    }
                