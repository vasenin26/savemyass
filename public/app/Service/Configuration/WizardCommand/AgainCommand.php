<?php

namespace app\Service\Configuration\WizardCommand;

use app\Http\RequestPayload;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Service\Configuration\Wizard;

class AgainCommand extends AbstractCommand
{
    public function __construct(private readonly RequestPayload $payload)
    {

    }

    public function execute(Wizard $wizard): Response
    {
        $wizard->next();

        return new Redirect('/wizard', $this->payload);
    }
}