<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Response\HtmlPage;
use app\Http\Response\Response;

interface WizardAction
{
    public function showForm(): HtmlPage;
    public function saveForm(): Response;
}
