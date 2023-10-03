<?php

namespace app\Http\Request;

class HttpRequest implements Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    public const PARAMS_KEY_URI = 'REQUEST_URI';
    public const PARAMS_KEY_METHOD = 'REQUEST_METHOD';

    public function __construct(private readonly array $params, private readonly array $payload)
    {
    }

    public function getUri(): string
    {
        return $this->params[self::PARAMS_KEY_URI];
    }

    public function getMethod(): string
    {
        return strtoupper($this->params[self::PARAMS_KEY_METHOD]);
    }

    public function getPayloadData(): array
    {
        return $this->payload;
    }

    public function getPayload(string $key): int|string|array|null
    {
        return $this->getPayloadData()[$key] ?? null;
    }
}
