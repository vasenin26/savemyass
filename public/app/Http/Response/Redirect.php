<?php

namespace app\Http\Response;

class Redirect implements Response, PayloadRedirect
{
    private array $errors = [];
    private array $payload = [];

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

    public function getPayload(): array
    {
        return [...$this->payload, 'errors' => $this->errors];
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
