#!/usr/bin/env php
<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Illuminate\Foundation\Application(__DIR__);

$app->useAppPath(is_dir($appPath = realpath(__DIR__.'/../../src')) ? $appPath : __DIR__.'/src');

/*
|--------------------------------------------------------------------------
| Register main engines
|--------------------------------------------------------------------------
*/

$app->singleton(Illuminate\Contracts\Console\Kernel::class, Gdl2Studio\IdeHelper\Console\Kernel::class);

$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Gdl2Studio\IdeHelper\Exceptions\Handler::class);


/*
|--------------------------------------------------------------------------
| Run The Artisan Application
|--------------------------------------------------------------------------
*/

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

/*
|--------------------------------------------------------------------------
| Shutdown The Application
|--------------------------------------------------------------------------
*/

$kernel->terminate($input, $status);

exit($status);



