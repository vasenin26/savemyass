<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;
use app\Storage\Payload;

interface WizardAction
{
    public function execute(): Response;
}
