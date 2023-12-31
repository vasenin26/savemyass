<?php

namespace Unit\Service\Configuration\WizardAction;

use app\Http\Request\HttpRequest;
use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardCommand\AbstractCommand;
use app\Service\Configuration\WizardCommand\Again;
use app\Service\Configuration\WizardCommand\Next;
use app\Service\Configuration\WizardCommand\ShowPage;
use app\Utils\Validator\NotEmpty;
use PHPUnit\Framework\TestCase;

class SetPasswordTest extends TestCase
{
    public function testGetHtmlPage()
    {
        $configuration = \Mockery::mock(MainConfiguration::class);
        $configuration->shouldReceive('getOptions')->andReturn([]);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getMethod')->andReturn(HttpRequest::METHOD_GET);

        $action = new SetPassword($configuration, $request);
        $response = $action->showForm();

        $this->assertInstanceOf(ShowPage::class, $response);
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

        $action = new SetPassword($configuration, $request);
        $response = $action->saveForm();

        $this->assertInstanceOf(Again::class, $response);
    }

    public function testSavePassword()
    {
        $testPassword = 'test_password';

        $configuration = \Mockery::mock(MainConfiguration::class, [
            'getOptions' => null,
            'save' => null
        ]);

        $configuration->shouldReceive('setOption')
            ->with('password', $testPassword);

        $request = \Mockery::mock(Request::class);
        $request->allows([
            'getMethod' => HttpRequest::METHOD_POST,
            'getPayload' => $testPassword
        ]);

        $action = new SetPassword($configuration, $request);
        $response = $action->saveForm();

        $this->assertInstanceOf(Next::class, $response);
    }

    /**
     * @dataProvider getWrongPassword
     */
    public function testSaveWrongPassword($password, $error)
    {
        $configuration = \Mockery::mock(MainConfiguration::class, [
            'getOptions' => null,
            'save' => null
        ]);

        $request = \Mockery::mock(Request::class);
        $request->allows([
            'getMethod' => HttpRequest::METHOD_POST,
            'getPayload' => $password
        ]);

        $action = new SetPassword($configuration, $request);
        $response = $action->saveForm();

        $this->assertInstanceOf(Again::class, $response);
        $errors = $response->getPayload()->getErrors();

        $this->assertEquals($errors['password'], $error);
    }

    public function getWrongPassword(): \Generator
    {
        yield 'Empty password' => [null, ['password.' . NotEmpty::ERROR]];
        yield 'Null password' => ['', ['password.' . NotEmpty::ERROR]];
    }
}
