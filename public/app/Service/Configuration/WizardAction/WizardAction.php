<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;
use app\Storage\Payload;

interface WizardAction
{
    public function showForm(): HtmlPage;
    public function saveForm(): Response;
}
