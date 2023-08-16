<?php

namespace Unit;

use app\App;
use app\Router;
use app\Service\Configuration\Configuration;
use Mockery;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testCreateApp() {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');

        $route = new Router($request);
        $configuration = Mockery::mock(\app\Service\Configuration\Configuration::class);
        $app = new App($configuration, $route);

        $this->assertInstanceOf(App::class, $app);
    }
}