<?php

namespace Gdl2Studio\IdeHelper\Generators;


use Illuminate\Support\Facades\Facade;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

class FacadeAnnotation
{
    //private ReflectionClass $facadeReflectionClass;

    private ReflectionClass $accessorReflectionClass;

    /**
     * FacadeAnnotationsGenerator constructor.
     *
     * @throws ReflectionException
     */
    private function __construct(string $accessorClassName)
    {
        $this->accessorReflectionClass = new ReflectionClass($accessorClassName);
    }

    /**
     * @throws ReflectionException
     */
    static function make(string $className): static
    {
        return new static(static::isFacade($className) ? get_class(($className)::getFacadeRoot()) : $className);
    }

    static function isFacade(string $className): bool
    {
        return is_subclass_of($className, Facade::class);
    }

    /**
     * @throws ReflectionException
     */
    function generate(): string
    {
        $methods = $this->accessorReflectionClass->getMethods();

        $annotations = [];

        foreach ($methods as $method) {
            if (!$method->isConstructor() and $method->isPublic() and !$method->isStatic()) {
                $annotations[$method->getName().' '.$this->processParameters($method->getParameters())] = $this->arrayToString([
                    ' * @method static',
                    $this->getReturnType($method).
                    $method->getName().
                    $this->processParameters($method->getParameters()),
                ]);
            }
        }

        ksort($annotations);

        return ' * @see \\'.$this->accessorReflectionClass->getName().PHP_EOL.
            implode(PHP_EOL, $annotations).PHP_EOL;
    }

    /**
     * @param ReflectionMethod $method
     *
     * @return string|null
     */
    protected function getReturnType(ReflectionMethod $method): ?string
    {
        $type = $method->getReturnType();
        if (class_exists($type)) {
            return '\\'.$type.' ';
        } elseif (is_null($type)) {
            return '';
        } else {
            return $type.' ';
        }
    }

    /**
     * @param ReflectionParameter[] $parameters
     *
     * @return string
     * @throws ReflectionException
     */
    protected function processParameters(array $parameters): string
    {
        $output       = [];
        $processValue = function (mixed $value) {
            return var_export($value, true);
        };

        foreach ($parameters as $parameter) {
            if ($parameter->isOptional()) {
                if ($parameter->isDefaultValueConstant()) {
                    $output[] = (string)$parameter->getType().' $'.$parameter->getName().' = '.$parameter->getDefaultValueConstantName();
                } else {
                    $output[] = (string)$parameter->getType().' $'.$parameter->getName().' = '.$processValue($parameter->getDefaultValue());
                }
            } else {
                $output[] = (string)$parameter->getType().' $'.$parameter->getName();
            }
        }
        return '('.implode(', ', $output).')';
    }

    /**
     * @param array $array
     *
     * @return string
     */
    protected function arrayToString(array $array): string
    {
        return implode(' ', $array);
    }

}