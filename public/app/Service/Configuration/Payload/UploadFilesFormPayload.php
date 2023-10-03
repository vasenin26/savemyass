<?php

namespace app\Service\Configuration\Payload;

use app\Http\AbstractPayload;
use app\Http\RequestPayload;
use app\Utils\Validator\NotEmpty;

/**
 * @method string getFinish
 * @method array getFile
 */
class UploadFilesFormPayload extends AbstractPayload implements RequestPayload
{
    protected array $rules = [
        'finish' => [],
        'file' => [NotEmpty::class]
    ];

    public function isFinish(): bool
    {
        $finish = $this->getFinish();

        return $finish == 1;
    }
}
