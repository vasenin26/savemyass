<?php

namespace Unit;

use app\App;
use app\ServiceContainer;
use PHPUnit\Framework\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testCreateApp() {
        $serviceContainer = new ServiceContainer();

        $app = $serviceContainer->resolve(App::class);

        $this->assertInstanceOf(App::class, $app);
    }
}
