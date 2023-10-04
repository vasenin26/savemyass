<?php

namespace app\Service\Configuration\WizardCommand;

use app\Http\Response\Response;
use app\Service\Configuration\Wizard;

abstract class AbstractCommand
{
    abstract public function execute(Wizard $wizard): Response;
}