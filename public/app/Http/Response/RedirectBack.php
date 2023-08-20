<?php

namespace app\Http\Response;

class RedirectBack implements Response
{
    private array $errors = [];

    private string $url;

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

    public function setError(string $key, string $value): void
    {
        $this->errors[$key] = $value;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
