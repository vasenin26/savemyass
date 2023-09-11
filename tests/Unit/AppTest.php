<?php

namespace Unit;

use app\App;
use app\Controller\Main;
use app\Router;
use app\ServiceContainer;
use app\Http\Response\Response;
use Mockery;
use PHPUnit\Framework\TestCase;
use Utils\FakeSession;

class AppTest extends TestCase
{
    public function testSuccessResponse()
    {
        $serviceContainer = Mockery::mock(ServiceContainer::class);

        $serviceContainer->shouldReceive('resolve')
            ->andReturn(Mockery::mock(ControllerInterface::class));

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getContent')->andReturn('ok');

        $serviceContainer->shouldReceive('call')->andReturn($response);

        $route = Mockery::mock(Router::class);

        $route->shouldReceive('getAction')->andReturn('getAction');
        $route->shouldReceive('getController')->andReturn(Main::class);

        $session = new FakeSession();

        $app = new App($serviceContainer, $route, $session);

        ob_start();
        $app->__invoke();
        $content = ob_get_clean();

        $this->assertInstanceOf(App::class, $app);
        $this->assertEquals('ok', $content);
    }
}
