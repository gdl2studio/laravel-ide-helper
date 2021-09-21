<?php

namespace Gdl2Studio\IdeHelper\Tests;

use Gdl2Studio\IdeHelper\IdeHelperServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;

    protected bool $loadEnvironmentVariables = true;

    protected string|null $environment = null;

    protected static function getPackagePath(string $path = ''): string
    {
        return realpath(__DIR__.'/../'.$path);
    }

    protected function getPackageProviders($app): array
    {
        if ($this->environment) {
            $app->detectEnvironment(fn () => $this->environment);
        }
        return [
            IdeHelperServiceProvider::class,
        ];
    }

    protected function getBasePath(): string
    {
        // make the app base path under tests\skeleton folder
        return realpath(__DIR__.'/_TestApp_');
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }
}
