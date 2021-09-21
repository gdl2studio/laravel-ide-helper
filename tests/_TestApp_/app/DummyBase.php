<?php

namespace TestApp;

class DummyBase
{
    public string|null $publicProperty = 'Hello, Dummy Base!';

    protected string|null $className = '';

    public function __construct()
    {
        $this->className = static::class;
    }

    public static function doStaticJob(string $job): void
    {
        echo 'Doing static '.$job.'...'.PHP_EOL;
    }

    public function returnTrue(): bool
    {
        return true;
    }

    public function doJob(string|array $job): static
    {
        echo $this->publicProperty.PHP_EOL;
        echo 'Doing '.$job.'...'.PHP_EOL;

        return $this;
    }

    protected function protectedFunction(string|array $a): bool
    {
        return true;
    }

    private function privateFunction(string|array $a): bool
    {
        return true;
    }
}
