<?php

namespace app\Service\Configuration\WizardCommand;

use app\Http\RequestPayload;
use app\Http\Response\HtmlPage;
use app\Http\Response\RedirectBack;
use app\Http\Response\Response;
use app\Service\Configuration\Wizard;

class ShowPage extends AbstractCommand
{
    public function __construct(private readonly HtmlPage $page)
    {

    }

    public function execute(Wizard $wizard): Response
    {
        return $this->page;
    }
}
