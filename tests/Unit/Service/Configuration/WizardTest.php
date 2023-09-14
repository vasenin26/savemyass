<?php

namespace Unit\Service\Configuration;

use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\WizardAction;
use app\ServiceContainer;
use PHPUnit\Framework\TestCase;
use app\Service\Configuration\MainConfiguration as ConfigurationUtil;
use app\Service\Configuration\Wizard;
use PHPUnit\TextUI\XmlConfiguration\Logging\TestDox\Html;

class WizardTest extends TestCase
{
    public function testGetAction()
    {
        $wizardAction = \Mockery::mock(WizardAction::class);
        $wizardAction->shouldReceive('execute')->andReturn(\Mockery::mock(Response::class));

        $serviceContainer = \Mockery::mock(ServiceContainer::class);
        $serviceContainer->shouldReceive('resolve')->andReturn($wizardAction);

        $configuration = \Mockery::mock(MainConfiguration::class, \ArrayAccess::class);
        $configuration->shouldReceive('isConfigured')->andReturn(false);
        $configuration->shouldReceive('isSet')->andReturn(false);
        $configuration->shouldReceive('getOptions')->andReturn([]);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $wizard = new Wizard($serviceContainer, $configuration, $request);

        $response = $wizard->execute($request);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testConfiguredWizard()
    {
        $wizardAction = \Mockery::mock(WizardAction::class);
        $wizardAction->shouldReceive('execute')->andReturn(\Mockery::mock(Response::class));

        $serviceContainer = \Mockery::mock(ServiceContainer::class);
        $serviceContainer->shouldReceive('resolve')->andReturn($wizardAction);

        $configuration = \Mockery::mock(MainConfiguration::class, \ArrayAccess::class);
        $configuration->shouldReceive('isConfigured')->andReturn(true);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $wizard = new Wizard($serviceContainer, $configuration, $request);

        $response = $wizard->execute();

        $this->assertInstanceOf(Response::class, $response);
    }
}
