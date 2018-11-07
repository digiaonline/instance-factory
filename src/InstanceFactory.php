<?php

namespace Digia\InstanceFactory;

use ReflectionClass;

/**
 * Class InstanceFactory
 * @package Digia\InstanceFactory
 */
class InstanceFactory
{

    /**
     * @param string $className
     * @param array  $properties
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public static function fromProperties(string $className, array $properties = [])
    {
        // Throw \RuntimeException instead of \ReflectionException
        try {
            $reflection = new ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \RuntimeException('\\ReflectionException: ' . $e->getMessage(), $e->getCode(), $e);
        }

        $invokeArgs = [];

        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            $parameterName = $parameter->getName();

            if (!array_key_exists($parameterName, $properties) && !$parameter->isOptional()) {
                throw new \RuntimeException(sprintf('Mandatory constructor parameter "%s" for class %s is missing from the given properties.',
                    $parameterName, $className));
            }

            $invokeArgs[] = array_key_exists($parameterName, $properties)
                ? $properties[$parameterName]
                : $parameter->getDefaultValue();
        }

        return $reflection->newInstanceArgs($invokeArgs);
    }
}
