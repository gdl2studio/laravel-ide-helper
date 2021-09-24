<?php
if (1)
{
    $message = (new class() extends Foo
    {
        public function bar()
        {
            echo 1;
        }
    });
}