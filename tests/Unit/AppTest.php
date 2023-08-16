<?php

namespace tests\Unit;

use app\App;
use app\Router;
use Mockery;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testCreateApp() {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');

        $route = new Router($request);
        $app = new App($route);

        $this->assertInstanceOf(App::class, $app);
    }
}