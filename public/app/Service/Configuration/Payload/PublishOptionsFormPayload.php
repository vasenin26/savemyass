<?php

namespace app\Service\Configuration\Payload;

use app\Http\AbstractPayload;
use app\Http\RequestPayload;
use app\Utils\Validator\NotEmpty;

/**
 * @method string getDelay
 * @method string getEmails
 * @method int isForAll
 */
class PublishOptionsFormPayload extends AbstractPayload implements RequestPayload
{
    protected array $rules = [
        'delay' => [NotEmpty::class],
        'emails' => [NotEmpty::class],
        'for_all' => []
    ];
}
