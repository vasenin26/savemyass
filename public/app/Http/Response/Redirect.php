<?php

namespace app\Http\Response;

class Redirect implements Response
{
    public function getContent(): string
    {
        return '';
    }

    public function getHeaders(): array
    {
        return [];
    }
}