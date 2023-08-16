<?php

namespace app\Http\Request;

class HttpRequest implements Request
{
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}