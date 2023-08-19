<?php

namespace app;

use app\Service\Configuration\MainConfiguration;

class ServiceContainer
{
    private array $map = [];

    public function __construct()
    {
        $this->map = require(__DIR__ . '/dependency.php');
    }

    /**
     * @throws \ReflectionException
     */
    public function resolve(string $className)
    {
        return $this->extract($className);
    }

    /**
     * @throws \ReflectionException
     */
    private function extract(string $className)
    {
        if($className === self::class) {
            return $this;
        }

        $targetClass = $className;

        if (array_key_exists($className, $this->map)) {
            $targetClass = $this->map[$className];

            if (is_callable($targetClass)) {
                return $this->map[$className] = $targetClass($this);
            }

            if (is_object($targetClass)) {
                return $targetClass;
            }
        }

        $reflection = new \ReflectionClass($targetClass);
        $args = [];

        $constructor = $reflection->getConstructor();
        if ($constructor) {
            $dependencies = $constructor->getParameters();

            if (!empty($dependencies)) {
                foreach ($dependencies as $dependency) {
                    $args[] = $this->extract($dependency->getType());
                }
            }
        }

        return $this->map[$className] = $reflection->newInstanceArgs($args);
    }

    /**
     * @throws \ReflectionException
     */
    public function call($classInstance, string $method)
    {
        $classReflection = new \ReflectionClass($classInstance);
        $methodReflection = $classReflection->getMethod($method);
        $dependencies = $methodReflection->getParameters();
        $args = [];

        foreach ($dependencies as $dependency) {
            $args[] = $this->extract($dependency->getType());
        }

        return $classInstance->$method(...$args);
    }
}
