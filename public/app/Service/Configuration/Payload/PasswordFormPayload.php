<?php

namespace app\Service\Configuration\Payload;

use app\Http\AbstractPayload;
use app\Http\RequestPayload;
use app\Utils\Validator\NotEmpty;

/**
 * @method string getPassword
 */
class PasswordFormPayload extends AbstractPayload implements RequestPayload
{
    protected array $rules = [
        'password' => [NotEmpty::class]
    ];
}
