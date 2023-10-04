<?php

namespace app\Service\Configuration\Payload;

use app\Http\AbstractPayload;
use app\Http\RequestPayload;
use app\Utils\Validator\NotEmpty;

/**
 * @method string getMessage
 */
class MessageFormPayload extends AbstractPayload implements RequestPayload
{
    protected array $rules = [
        'message' => [NotEmpty::class]
    ];
}
