<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\Configuration;

interface WizardAction
{
    public function __construct(Configuration $configuration, Request $request);

    public function execute(): Response;
}