<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;

class FullConfigured implements WizardAction
{
    public function __construct(MainConfiguration $configuration, Request $request)
    {
    }

    public function showForm(): HtmlPage
    {
        // TODO: Implement showForm() method.
    }

    public function saveForm(): Response
    {
        return new Redirect('/');
    }
}
