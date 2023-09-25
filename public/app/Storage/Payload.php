<?php

declare(strict_types=1);

namespace app\Storage;

use app\Http\RequestPayload;
use app\Utils\ValidationErrors;

class Payload
{
    private ?RequestPayload $payload;

    public function __construct(Session $session)
    {
        $this->payload = $session->getPayload();
    }

    /**
     * @retun ValidationErrors[]
     */
    public function getErrors(): ValidationErrors
    {
        $errors = [];

        if($this->payload) {
            $errors = $this->payload->getErrors();
        }

        return new ValidationErrors($errors);
    }
}
