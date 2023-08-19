<?php

namespace Unit\Service\Configuration;

use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\WizardAction\SetPassword;
use PHPUnit\Framework\TestCase;
use app\Service\Configuration\MainConfiguration as ConfigurationUtil;
use app\Service\Configuration\Wizard;
use PHPUnit\TextUI\XmlConfiguration\Logging\TestDox\Html;

class WizardTest extends TestCase
{
    public function testGetAction()
    {
        $configuration = \Mockery::mock(MainConfiguration::class, \ArrayAccess::class);
        $configuration->shouldReceive('isConfigured')->andReturn(false);
        $configuration->shouldReceive('isSet')->andReturn(false);
        $configuration->shouldReceive('getOptions')->andReturn([]);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $wizard = new Wizard($configuration, $request);

        $response = $wizard->execute($request);

        $this->assertInstanceOf(HtmlPage::class, $response);
    }

    public function testConfiguredWizard()
    {
        $configuration = \Mockery::mock(MainConfiguration::class, \ArrayAccess::class);
        $configuration->shouldReceive('isConfigured')->andReturn(true);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $wizard = new Wizard($configuration, $request);

        $response = $wizard->execute();

        $this->assertInstanceOf(Redirect::class, $response);
        $this->assertEquals('/', $response->url);
    }
}
