<?php

namespace app\Http\Response;

class Redirect implements Response
{
    private array $errors = [];

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

    public function setError(string $key, string $value): void
    {
        $this->errors[$key] = $value;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
