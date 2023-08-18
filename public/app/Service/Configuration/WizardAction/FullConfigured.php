<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Service\Configuration\Configuration;

class FullConfigured implements WizardAction
{
    public function __construct(Configuration $configuration, Request $request)
    {
    }

    public function execute(): Response
    {
        return new Redirect('/');
    }
}
