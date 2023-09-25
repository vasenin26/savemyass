<?php

namespace app\Http;

interface RequestPayload
{
    public function isValid(): bool;

    public function getErrors();
}