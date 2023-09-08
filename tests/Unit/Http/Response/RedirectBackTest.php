<?php

namespace Unit\Http\Response;

use app\Http\Response\RedirectBack;
use PHPUnit\Framework\TestCase;

class RedirectBackTest extends TestCase
{
    public function testCreateBackRedirect(): void
    {
        $redirect = new RedirectBack();
        $headers = $redirect->getHeaders();
        $content = $redirect->getContent();

        $this->assertEquals('Location: /', $headers[0]);
        $this->assertEquals('', $content);
    }
}
