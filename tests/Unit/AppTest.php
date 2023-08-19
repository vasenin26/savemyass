<?php

namespace Unit;

use app\App;
use app\Router;
use app\ServiceContainer;
use Mockery;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testCreateApp()
    {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');

        $serviceContainer = new ServiceContainer();
        $route = new Router($request);

        $app = new App($serviceContainer, $route);

        $this->assertInstanceOf(App::class, $app);
    }
}