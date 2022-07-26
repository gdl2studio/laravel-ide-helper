<?php
$foo = new class () extends \Exception
{
    protected $message = "Surprise";
};
