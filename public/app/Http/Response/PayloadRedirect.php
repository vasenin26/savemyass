<?php

namespace app\Http\Response;

use app\Http\RequestPayload;

interface PayloadRedirect
{
    public function getPayload(): ?RequestPayload;
    public function setPayload(RequestPayload $payload): void;
}
