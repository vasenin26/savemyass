<?php

namespace app\Controller;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\WizardAction;

class Wizard extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function getAction(Request $request): Response
    {
        return $this->getWizardAction($request);
    }

    /**
     * @throws \Exception
     */
    public function postAction(Request $request): Response
    {
        return $this->getWizardAction($request);
    }

    /**
     * @throws \Exception
     */
    private function getWizardAction(Request $request): Response
    {
        return (new \app\Service\Configuration\Wizard($this->configuration, $request))->execute();
    }
}