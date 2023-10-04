<?php

namespace app\Service\Configuration\WizardCommand;

use app\Http\Response\RedirectBack;
use app\Http\Response\Response;
use app\Service\Configuration\Wizard;

class Reset extends AbstractCommand
{
    public function execute(Wizard $wizard): Response
    {
        $wizard->reset();

        return new RedirectBack();
    }
}
