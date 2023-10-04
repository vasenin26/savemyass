<?php

namespace Unit\Service\Configuration;

use app\Http\Response\HtmlPage;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\WizardAction\WizardAction;
use app\Service\Configuration\WizardCommand\AbstractCommand;
use app\ServiceContainer;
use app\Storage\Session;
use PHPUnit\Framework\TestCase;
use app\Service\Configuration\Wizard;

;

class WizardTest extends TestCase
{
    public function testGetAction()
    {
        $command = \Mockery::mock(AbstractCommand::class);
        $command->shouldReceive('execute')->andReturn(\Mockery::mock(HtmlPage::class));

        $wizardAction = \Mockery::mock(WizardAction::class);
        $wizardAction->shouldReceive('showForm')->andReturn($command);

        $serviceContainer = \Mockery::mock(ServiceContainer::class);
        $serviceContainer->shouldReceive('resolve')->andReturn($wizardAction);

        $configuration = \Mockery::mock(MainConfiguration::class, \ArrayAccess::class);
        $configuration->shouldReceive('isConfigured')->andReturn(false);
        $configuration->shouldReceive('isSet')->andReturn(false);
        $configuration->shouldReceive('getOptions')->andReturn([]);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $session = \Mockery::mock(\app\Storage\Session::class);
        $session->shouldReceive('getOption')->andReturn(0);

        $wizard = new Wizard($serviceContainer, $configuration, $request, $session);

        $response = $wizard->execute($request);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testConfiguredWizard()
    {
        $command = \Mockery::mock(AbstractCommand::class);
        $command->shouldReceive('execute')->andReturn(\Mockery::mock(HtmlPage::class));

        $wizardAction = \Mockery::mock(WizardAction::class);
        $wizardAction->shouldReceive('showForm')->andReturn($command);

        $serviceContainer = \Mockery::mock(ServiceContainer::class);
        $serviceContainer->shouldReceive('resolve')->andReturn($wizardAction);

        $configuration = \Mockery::mock(MainConfiguration::class, \ArrayAccess::class);
        $configuration->shouldReceive('isConfigured')->andReturn(true);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $session = \Mockery::mock(\app\Storage\Session::class);
        $session->shouldReceive('getOption')->andReturn(0);

        $wizard = new Wizard($serviceContainer, $configuration, $request, $session);

        $response = $wizard->execute();

        $this->assertInstanceOf(Response::class, $response);
    }
}
