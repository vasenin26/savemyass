<?php

namespace app\Http\Response;

interface PayloadRedirect
{
    public function getPayload(): array;
    public function setPayload(array $payload): void;
}
