<?php

declare(strict_types=1);

namespace app\Storage;

use app\Utils\ValidationErrors;

class Payload
{
    /**
     * @var array|array[]
     */
    private array $payload;

    public function __construct(Session $session)
    {
        $this->payload = $session->getPayload();
    }

    /**
     * @retun ValidationErrors[]
     */
    public function getErrors(): ValidationErrors
    {
        return new ValidationErrors($this->payload['errors'] ?? []);
    }
}
