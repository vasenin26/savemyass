<?php

namespace app\Storage;

use app\Utils\ValidationErrors;

class Payload
{
    public function __construct(Session $session)
    {
        $this->payload = $session->getPayload();
    }

    /**
     * @retun ValidationErrors[]
     */
    public function getErrors(): ValidationErrors
    {
        return new ValidationErrors($this->payload->errors ?? []);
    }
}