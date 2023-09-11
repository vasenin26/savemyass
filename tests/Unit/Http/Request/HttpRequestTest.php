<?php

namespace Unit\Http\Request;

use app\Http\Request\HttpRequest;
use PHPUnit\Framework\TestCase;

class HttpRequestTest extends TestCase
{
    public function testGetMethod()
    {
        $request = new HttpRequest([HttpRequest::PARAMS_KEY_METHOD => HttpRequest::METHOD_GET], []);

        $this->assertEquals(HttpRequest::METHOD_GET, $request->getMethod());
    }
    public function testGetUrl()
    {
        $uri = '/test-url';
        $request = new HttpRequest([HttpRequest::PARAMS_KEY_URI => $uri], []);

        $this->assertEquals($uri, $request->getUri());
    }

    public function testGetPayload()
    {
        $payload = ['key' => 'value'];
        $request = new HttpRequest([], $payload);

        $this->assertEquals($payload, $request->getPayloadData());
    }

    public function testGetPayloadByKey()
    {
        $payload = ['key' => 'value'];
        $request = new HttpRequest([], $payload);

        $this->assertEquals('value', $request->getPayload('key'));
    }
}
