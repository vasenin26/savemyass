<?php

namespace Unit;

use app\Controller\Main;
use app\Controller\Prolongation;
use app\Router;
use Mockery;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @dataProvider getControllerMap
     * @throws \Exception
     */
    public function testGetDefinedController($uri, $exceptedController): void
    {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn($uri);

        $route = new Router($request);

        $controller = $route->getController();

        $this->assertEquals($exceptedController, $controller);
    }

    public function testGetMethodAction()
    {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getMethod')->andReturn('GET');

        $route = new Router($request);

        $this->assertEquals('getAction', $route->getAction());
    }

    public function getControllerMap(): \Iterator
    {
        yield 'Main Controller' => ['/', Main::class];
        yield 'Prolongation Controller' => ['/s', Prolongation::class];
    }

    public function testGetUndefinedController(): void
    {
        $request = Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/wrong-url');

        $route = new Router($request);

        $this->expectException(\Exception::class);

        $route->getController();
    }
}
