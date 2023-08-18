<?php

namespace Unit\Controller;

use app\Controller\Main;
use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\ProtectedPage;
use app\Http\Response\Redirect;
use app\Service\Configuration\MainConfiguration;
use app\Service\Publisher\DataPublisher;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testConfigurationRedirect()
    {
        $configuration = \Mockery::mock(MainConfiguration::class);
        $configuration->shouldReceive('isConfigured')->andReturn(false);

        $publisher = \Mockery::mock(DataPublisher::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn('GET');

        $main = new Main($configuration, $publisher);

        $response = $main->getAction($request);

        $this->assertInstanceOf(Redirect::class, $response);
        $this->assertEquals('/wizard', $response->url);
    }

    public function testCheckDataProtection()
    {
        $configuration = \Mockery::mock(MainConfiguration::class);
        $configuration->shouldReceive('isConfigured')->andReturn(true);
        $configuration->shouldReceive('isPublish')->andReturn(false);

        $publisher = \Mockery::mock(DataPublisher::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn('GET');

        $main = new Main($configuration, $publisher);

        $response = $main->getAction($request);

        $this->assertInstanceOf(ProtectedPage::class, $response);
    }

    public function testCheckDataPublish()
    {
        $configuration = \Mockery::mock(MainConfiguration::class);
        $configuration->shouldReceive('isConfigured')->andReturn(true);
        $configuration->shouldReceive('isPublish')->andReturn(true);

        $publisher = \Mockery::mock(DataPublisher::class);
        $publisher->shouldReceive('getPublicPage')->andReturn(new HtmlPage(''));
        $publisher->shouldReceive('publish');

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn('GET');

        $main = new Main($configuration, $publisher);

        $response = $main->getAction($request);

        $this->assertInstanceOf(HtmlPage::class, $response);
    }
}
