<?php

namespace app\Http\Request;

class HttpRequest implements Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}