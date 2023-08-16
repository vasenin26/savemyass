<?php

namespace Unit\Service\Configuration;

use app\Http\Response\HtmlPage;
use PHPUnit\Framework\TestCase;
use app\Service\Configuration\Configuration as ConfigurationUtil;
use app\Service\Configuration\Wizard;

class WizardTest extends TestCase
{
    public function testGetAction()
    {
        $storage = \Mockery::mock(\app\Storage\Configuration::class);
        $storage->shouldReceive('getOptions')
            ->andReturn([]);

        $configuration = new ConfigurationUtil($storage);

        $request = \Mockery::mock(\app\Http\Request\Request::class);
        $request->shouldReceive('getUri')->andReturn('/');
        $request->shouldReceive('getMethod')->andReturn(\app\Http\Request\HttpRequest::METHOD_GET);

        $wizard = new Wizard($configuration);

        $response = $wizard->getPage($request);

        $this->assertInstanceOf(HtmlPage::class, $response);
    }
}
