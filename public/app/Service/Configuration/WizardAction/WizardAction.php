<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Response\HtmlPage;
use app\Service\Configuration\WizardCommand\AbstractCommand;

interface WizardAction
{
    public function showForm(): AbstractCommand;
    public function saveForm(): AbstractCommand;
}
