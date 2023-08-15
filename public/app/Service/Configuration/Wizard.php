<?php

namespace app\Service\Configuration;

use app\Http\Request\HttpRequest;
use app\Http\Response\HtmlPage;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\WizardAction;
use Exception;

class Wizard
{
    public function __construct(private Configuration $configuration)
    {

    }

    /**
     * @throws Exception
     */
    public function getPage(Request $request): Response
    {
        $state = $this->getWizardState();
        $stateAction = $this->getStateAction($state, $request);

        return $stateAction->execute();
    }

    /**
     * @throws Exception
     */
    public function getStateAction(string $state, HttpRequest $request): WizardAction
    {
        $actionClass = [
            'password_form' => SetPassword::class
        ][$state] ?? null;

        if (!$actionClass) {
            throw new Exception('Unknown wizard state', 500);
        }

        return new $actionClass($this->configuration, $request);
    }

    /**
     * @throws Exception
     */
    private function getWizardState(): string
    {
        $options = [
            'password' => 'password_form'
        ];

        foreach ($options as $option => $state) {
            if ($this->configuration->getOption($option) === null) {
                return $state;
            }
        }

        throw new Exception('Nothing to set up', 500);
    }
}