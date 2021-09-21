<?php

namespace Gdl2Studio\IdeHelper;

use Gdl2Studio\IdeHelper\Generators\FacadeAnnotation;
use Illuminate\Support\Str;
use ReflectionException;
use Symfony\Component\Finder\SplFileInfo;

class PhpFile
{
    private SplFileInfo $fileInfo;

    private string $namespace = '';

    private string $definedClass = '';

    private string $classAnnotation = '';

    private function __construct(SplFileInfo|string $file, string|null $appPath = null)
    {
        $this->fileInfo = is_string($file) ?
            new SplFileInfo(
                $file = realpath($file),
                $relativePath = dirname($appPath ? Str::after($file, realpath($appPath)) : $file),
                $relativePath.DIRECTORY_SEPARATOR.basename($file)
            )
            :
            $file;

        $this->parse();
    }

    public static function make(SplFileInfo|string $file, string|null $appPath = null): PhpFile
    {
        return new static($file, $appPath);
    }

    public function getFileInfo(): SplFileInfo
    {
        return $this->fileInfo;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getFQCN(): string
    {
        return $this->namespace.'\\'.$this->definedClass;
    }

    public function getClassAnnotation(): string
    {
        return $this->classAnnotation;
    }

    public function getClassAnnotationBody(): string
    {
        return preg_replace('/^\s*\//', '',
            preg_replace('/(\s|\*)+$/is', '',
                preg_replace('/\r\n((\h|\r)*\n)+/is', PHP_EOL,
                    preg_replace('/^\h*\*\h*@(method|see).*$/mi', '',
                        preg_replace('/\s*\*\/\s*$/i', '',
                            preg_replace('/^\s*\/\*+(\s)*'.PHP_EOL.'/i', '',
                                $this->classAnnotation
                            ))))));
    }

    public function getContents(): string
    {
        return $this->fileInfo->getContents();
    }

    public function parse(): void
    {
        $contents = $this->getContents();
        $this->parseNamespace($this->removeComments($contents));
        $this->parseDefinedClass($this->removeComments($contents));
        $this->parseClassAnnotations($contents);
    }


    public function updateClassAnnotation(string $annotation, bool $write = true): string
    {
        $oldAnnotation = $this->classAnnotation;

        $this->classAnnotation =
            '/**'.PHP_EOL.
            (($body = $this->getClassAnnotationBody()) ? $body.PHP_EOL.' * '.PHP_EOL : '').
            $annotation.
            ' */';

        return $this->setContents(
        // leave no empty lines between annotation and class definition
            preg_replace('/(\*\/)\s*(class\s+'.$this->definedClass.')/Uis', '\1'.PHP_EOL.'\2',
                $oldAnnotation ?
                    // replace old annotation
                    str_replace($oldAnnotation,
                        $this->classAnnotation,
                        $this->getContents())
                    :
                    // insert new annotation
                    preg_replace('/^(\s*class\s+'.$this->definedClass.')/mi',
                        PHP_EOL.PHP_EOL.$this->classAnnotation.'\1',
                        $this->getContents())
            ),
            $write
        );
    }


    public function cleanUpClassAnnotation(bool $write = true): string
    {
        if ($this->classAnnotation) {
            $oldAnnotations = $this->classAnnotation;

            $this->classAnnotation = ($body = $this->getClassAnnotationBody()) ?
                '/**'.PHP_EOL.$body.PHP_EOL.' */'
                :
                '';

            return $this->setContents(
                preg_replace('/(\*\/)\s*(class\s+'.$this->definedClass.')/Uis',
                    '\1'.PHP_EOL.'\2',
                    str_replace($oldAnnotations,
                        $this->classAnnotation,
                        $this->getContents())
                ),
                $write
            );
        }

        return '';
    }


    public function isFacade(): bool
    {
        return FacadeAnnotation::isFacade($this->getFQCN());
    }

    /**
     * @throws ReflectionException
     */
    public function updateFacadeAnnotation(bool $write = true): string
    {
        return $this->updateClassAnnotation(
            FacadeAnnotation::make($this->getFQCN())->generate(),
            $write
        );
    }


    protected function parseClassAnnotations(string $contents): string
    {
        if (preg_match('/(\/\*\*((?!\*\/).)*\*\/)\s+class\s+'.$this->definedClass.'(\s|\{)/Uis', $contents, $m)) {
            $this->classAnnotation = $m[1];
        } else {
            $this->classAnnotation = '';
        }

        return $this->classAnnotation;
    }


    protected function parseDefinedClass(string $contents): string
    {
        if (preg_match('/^\h*class\s+(\S+)(\s|\{)/mUis', $contents, $m)) {
            $this->definedClass = $m[1];
        } else {
            $this->definedClass = '';
        }

        return $this->definedClass;
    }

    protected function parseNamespace(string $contents): string
    {
        if (preg_match('/<\?php\s+namespace\s+(.*);/Uis', $contents, $m)) {
            $this->namespace = $m[1];
        } else {
            $this->namespace = '';
        }

        return $this->namespace;
    }

    protected function removeComments(string $str): string
    {
        return
            preg_replace('/\/\*.*\*\//Uis', '',
                preg_replace('/(\/\/|#).*'.PHP_EOL.'/', PHP_EOL, $str)
            );
    }

    protected function setContents(string $contents, bool $write = true): string
    {
        if ($write and $resource = fopen($this->fileInfo->getPathname(), 'w')) {
            fwrite($resource, $contents);
            fclose($resource);
        }

        return $write ? $contents : $this->classAnnotation;
    }
}