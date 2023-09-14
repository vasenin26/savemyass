<?php

namespace Http\Response;

use app\Http\Response\Redirect;
use PHPUnit\Framework\TestCase;

class RedirectTest extends TestCase
{
    public function testCreateRedirect(): void
    {
        $redirectUri = '/redirect-uri';
        $redirect = new Redirect($redirectUri);
        $headers = $redirect->getHeaders();
        $content = $redirect->getContent();

        $this->assertEquals("Location: $redirectUri", $headers[0]);
        $this->assertEquals('', $content);
    }
}
