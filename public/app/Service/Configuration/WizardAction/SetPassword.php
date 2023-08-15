<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Response\Response;
use \app\Service\Configuration\Configuration;
use app\Http\Request\HttpRequest;

class SetPassword implements WizardAction
{
    public function __construct(private Configuration $configuration, private HttpRequest $request)
    {

    }

    public function execute(): Response
    {

    }
}