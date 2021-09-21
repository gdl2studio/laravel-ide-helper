<?php

namespace Gdl2Studio\IdeHelper;

use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

class IdeHelper
{
    protected bool $write = false;

    protected Collection $parsedFacades;

    public function __construct()
    {
        $this->parsedFacades = collect();
    }

    public function withNoWrite(): static
    {
        $this->write = false;

        return $this;
    }

    public function withWrite(bool $write = true): static
    {
        $this->write = $write;

        return $this;
    }

    public function parseAppFacades(): static
    {
        $this->parsedFacades = $this->getAppFacades()->map(
            fn (PhpFile $phpFile) => $phpFile->updateFacadeAnnotation($this->write)
        );

        return $this;
    }

    public function cleanUpAppFacades(): static
    {
        $this->parsedFacades = $this->getAppFacades()->map(
            fn (PhpFile $phpFile) => $phpFile->cleanUpClassAnnotation($this->write)
        );

        return $this;
    }

    public function getAppFacades(): Collection
    {
        $facades = collect();
        $appPath = app_path();

        foreach ((new Finder)->in($appPath)->name('*.php')->files() as $file) {
            if (($phpFile = PhpFile::make($file, $appPath))->isFacade()) {
                $facades[$phpFile->getFQCN()] = $phpFile;
            }
        }

        return $facades;
    }

    public function getParsedFacades(): Collection
    {
        return $this->parsedFacades;
    }
}
