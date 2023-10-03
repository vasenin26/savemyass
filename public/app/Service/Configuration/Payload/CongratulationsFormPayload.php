<?php

namespace app\Service\Configuration\Payload;

use app\Http\AbstractPayload;
use app\Http\RequestPayload;
use app\Utils\Validator\NotEmpty;

class CongratulationsFormPayload extends AbstractPayload implements RequestPayload
{
    protected array $rules = [
        'save' => [],
        'reset' => []
    ];

    public function isSave(): bool
    {
        return $this->request->getPayload('save') == 1;
    }

    public function isReset(): bool
    {
        return $this->request->getPayload('reset') == 1;
    }
}
