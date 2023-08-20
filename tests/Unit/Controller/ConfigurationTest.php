<?php

namespace Unit\Controller;

use app\Controller\Configuration;
use app\Http\Request\Request;
use app\Http\Response\RedirectBack;
use app\I18n\I18n;
use app\Storage\Session;
use PHPUnit\Framework\TestCase;
use Utils\FakeSession;

class ConfigurationTest extends TestCase
{
    public function testSaveConfiguration(): void
    {
        $targetLang = 'fake';

        $session = new FakeSession();
        $i18n = \Mockery::mock(I18n::class);

        $i18n->allows(['getAvailableLanguages' => [$targetLang => 'Fake Language']]);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('getPayload')->andReturn($targetLang);

        $controller = new Configuration($session, $i18n);
        $response = $controller->postAction($request);

        $this->assertInstanceOf(RedirectBack::class, $response);
        $this->assertEquals($targetLang, $session->getOption(Session::OPTION_LANG));
    }
}
