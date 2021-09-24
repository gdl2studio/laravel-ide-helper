<?php
    function foo($a) {
        // foo
        $foo = new class($a) extends Foo
        {
            public function bar() {
            }
        };
    }