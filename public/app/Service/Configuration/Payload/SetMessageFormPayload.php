<?php

namespace app\Service\Configuration\Payload;

use app\Http\AbstractPayload;
use app\Http\RequestPayload;
use app\Utils\Validator\NotEmpty;

/**
 * @method string getPassword
 */
class SetMessageFormPayload extends AbstractPayload implements RequestPayload
{
    protected array $rules = [
        'message' => [NotEmpty::class]
    ];
}
