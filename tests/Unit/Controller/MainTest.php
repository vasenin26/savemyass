<?php

namespace Unit\Controller;

use app\Controller\Main;
use app\Http\Request\Request;
use app\Http\Response\ProtectedPage;
use app\Service\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testCheckDataProtection()
    {
        $configuration = \Mockery::mock(Configuration::class);
        $configuration->shouldReceive('isConfigured')->andReturn(true);
        $configuration->shouldReceive('isPublish')->andReturn(false);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn('GET');

        $main = new Main($configuration);

        $response = $main->getAction($request);

        $this->assertInstanceOf(ProtectedPage::class, $response);
    }
}
