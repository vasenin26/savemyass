<?php

namespace Unit\Controller;

use app\Controller\Wizard as WizardController;
use app\Http\Response\Redirect;
use app\Service\Configuration\Wizard;
use app\Http\Request\Request;
use PHPUnit\Framework\TestCase;

class WizardTest extends TestCase
{
    public const TEST_REDIRECT_URL = '/test-redirect-url';
    public function testGetAction()
    {
        $wizard = \Mockery::mock(Wizard::class);
        $wizard->shouldReceive('execute')->andReturn(new Redirect(self::TEST_REDIRECT_URL));

        $request = \Mockery::mock(Request::class);

        $controller = new WizardController($wizard);
        $response = $controller->getAction($request);

        $this->assertInstanceOf(Redirect::class, $response);
        $this->assertEquals(self::TEST_REDIRECT_URL, $response->url);
    }

    public function testPostAction()
    {
        $wizard = \Mockery::mock(Wizard::class);
        $wizard->shouldReceive('execute')->andReturn(new Redirect(self::TEST_REDIRECT_URL));

        $request = \Mockery::mock(Request::class);

        $controller = new WizardController($wizard);
        $response = $controller->postAction($request);

        $this->assertInstanceOf(Redirect::class, $response);
        $this->assertEquals(self::TEST_REDIRECT_URL, $response->url);
    }
}
