<?php

namespace app\Http\Response;

class Redirect implements Response
{
    public function __construct(readonly string $url)
    {

    }

    public function getContent(): string
    {
        return '';
    }

    public function getHeaders(): array
    {
        return [
            "Location: {$this->url}"
        ];
    }
}