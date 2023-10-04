<?php

namespace app\Http\Response;

class RedirectBack implements Response
{
    private array $errors = [];

    public function __construct()
    {
        $this->url = $_SERVER['HTTP_REFERER'] ?? '/';
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
