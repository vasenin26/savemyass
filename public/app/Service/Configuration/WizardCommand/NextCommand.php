<?php

namespace app\Service\Configuration\WizardCommand;

use app\Http\Response\RedirectBack;
use app\Http\Response\Response;
use app\Service\Configuration\Wizard;

class NextCommand extends AbstractCommand
{

    public function execute(Wizard $wizard): Response
    {
        $wizard->next();

        return new RedirectBack();
    }
}