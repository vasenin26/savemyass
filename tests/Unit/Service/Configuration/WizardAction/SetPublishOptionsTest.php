<?php

namespace Unit\Service\Configuration\WizardAction;

use app\Http\Request\HttpRequest;
use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\SetPublishOptions;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

class SetPublishOptionsTest extends TestCase
{
    public function testGetHtmlPage()
    {
        $configuration = \Mockery::mock(MainConfiguration::class);
        $configuration->shouldReceive('getOptions')->andReturn([]);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getMethod')->andReturn(HttpRequest::METHOD_GET);

        $action = new SetPublishOptions($configuration, $request);
        $response = $action->execute();

        $this->assertInstanceOf(HtmlPage::class, $response);
    }

    public function testGetRedirectAfterOptionSet()
    {
        $configuration = \Mockery::mock(MainConfiguration::class);
        $configuration->allows([
            'getOptions' => [],
            'setOption' => null,
            'save' => null
        ]);

        $request = \Mockery::mock(Request::class);
        $request->allows([
            'getMethod' => HttpRequest::METHOD_POST,
            'getPayload' => null
        ]);

        $action = new SetPublishOptions($configuration, $request);
        $response = $action->execute();

        $this->assertInstanceOf(Redirect::class, $response);
    }

    public function testSavePublishOptions()
    {
        $delay = 14;
        $emails = 'test@mail.com;test2@mail.com';
        $forAll = false;

        $configuration = \Mockery::mock(MainConfiguration::class, [
            'getOptions' => null,
            'save' => null,
            'setOption' => null
        ]);

        $request = \Mockery::mock(Request::class);
        $request->allows([
            'getMethod' => HttpRequest::METHOD_POST
        ]);
        $request->shouldReceive('getPayload')
            ->andReturn($delay, $emails, $forAll);

        $action = new SetPublishOptions($configuration, $request);
        $response = $action->execute();

        $this->assertInstanceOf(Redirect::class, $response);
        $this->assertEmpty($response->getErrors());
    }

    /**
     * @dataProvider optionsProvider
     */
    public function testSaveWrongOptions($options, $errors)
    {
        list($delay, $emails, $forAll) = $options;

        $configuration = \Mockery::mock(MainConfiguration::class, [
            'getOptions' => null,
            'save' => null,
            'setOption' => null
        ]);

        $request = \Mockery::mock(Request::class);
        $request->allows([
            'getMethod' => HttpRequest::METHOD_POST
        ]);
        $request->shouldReceive('getPayload')
            ->andReturn($delay, $emails, $forAll);

        $action = new SetPublishOptions($configuration, $request);
        $response = $action->execute();

        $this->assertInstanceOf(Redirect::class, $response);
        $this->assertEquals($errors, $response->getErrors());
    }

    public function optionsProvider()
    {
        yield 'Wrong delay' => [[null, 'test@mail.com', false], ['delay' => 'error.empty_delay']];
        yield 'Wrong email' => [[1, null, false], ['emails' => 'error.emails_not_set']];
    }
}