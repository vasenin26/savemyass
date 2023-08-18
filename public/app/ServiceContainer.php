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

        if (array_key_exists($className, $this->map)) {
            $instance = $this->map[$className];

            if (is_callable($instance)) {
                return $this->map[$className] = $instance($this);
            }

            if (is_object($instance)) {
                return $instance;
            }
        }

        $reflection = new \ReflectionClass($className);
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
}
