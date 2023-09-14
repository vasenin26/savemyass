<?php

namespace Unit;

use app\App;
use app\ServiceContainer;
use app\Storage\Session;
use PHPUnit\Framework\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testCreateApp()
    {
        $serviceContainer = new ServiceContainer();

        $app = $serviceContainer->resolve(App::class);

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @dataProvider classnameProvider
     */
    public function testCreateRegisteredServices($serviceClass)
    {
        $serviceContainer = new ServiceContainer();

        $app = $serviceContainer->resolve($serviceClass);

        $this->assertInstanceOf($serviceClass, $app);
    }

    public function testCallAvailableServiceMethod()
    {
        $instance = new class{
            public function testMethod(Session $session){
                return true;
            }
        };

        $serviceContainer = new ServiceContainer();
        $result = $serviceContainer->call($instance, 'testMethod');

        $this->assertTrue($result);
    }

    public function classnameProvider(): \Generator
    {
        foreach (array_keys(include 'public/app/dependency.php') as $service) {
            yield $service => [$service];
        }
    }

}
