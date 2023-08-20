<?php

namespace Unit;

use app\App;
use app\Router;
use app\ServiceContainer;
use Mockery;
use PHPUnit\Framework\TestCase;
use Utils\FakeSession;

class AppTest extends TestCase
{
    public function testCreateApp()
    {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');

        $serviceContainer = new ServiceContainer();
        $route = new Router($request);

        $session = new FakeSession();

        $app = new App($serviceContainer, $route, $session);

        $this->assertInstanceOf(App::class, $app);
    }
}