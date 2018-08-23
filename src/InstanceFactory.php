<?php

namespace Digia\InstanceFactory;

use ReflectionClass;
use RuntimeException;

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
     * @throws RuntimeException
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public static function fromProperties(string $className, array $properties = [])
    {
        $reflection = new ReflectionClass($className);

        $invokeArgs = [];

        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            $parameterName = $parameter->getName();

            if (!array_key_exists($parameterName, $properties) && !$parameter->isOptional()) {
                throw new RuntimeException(sprintf('Mandatory constructor parameter "%s" for class %s is missing from the given properties.',
                    $parameterName, $className));
            }

            $invokeArgs[] = array_key_exists($parameterName, $properties)
                ? $properties[$parameterName]
                : $parameter->getDefaultValue();
        }

        return $reflection->newInstanceArgs($invokeArgs);
    }
}
