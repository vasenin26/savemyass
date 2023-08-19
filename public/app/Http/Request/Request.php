<?php

namespace app\Http\Request;

interface Request
{
    public function getUri(): string;

    public function getPayloadData(): array;

    public function getPayload(string $key): int|string|null;
}
