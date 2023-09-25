<?php

namespace app\Http\Response;

use app\Http\RequestPayload;

class Redirect implements Response, PayloadRedirect
{
    private array $errors = [];

    public function __construct(readonly string $url, private ?RequestPayload $payload = null)
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

    public function getErrors(): array
    {
        if($this->payload) {
            return $this->payload->getErrors();
        }

        return [];
    }

    public function getPayload(): ?RequestPayload
    {
        return $this->payload;
    }

    public function setPayload(RequestPayload $payload): void
    {
        $this->payload = $payload;
    }
}
