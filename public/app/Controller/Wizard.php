<?php

namespace app\Controller;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\WizardAction\WizardAction;
use app\Service\Publisher\DataPublisher;

class Wizard
{
    public function __construct(private readonly MainConfiguration $configuration)
    {

    }
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
