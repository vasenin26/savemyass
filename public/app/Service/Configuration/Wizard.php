<?php

namespace app\Service\Configuration;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\WizardAction;
use Exception;

class Wizard
{
    private const STATE_SET_PASSWORD = 'password_form';

    public function __construct(private readonly Configuration $configuration)
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
    private function getStateAction(string $state, Request $request): WizardAction
    {
        $actionClass = [
            self::STATE_SET_PASSWORD => SetPassword::class
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
            'password' => self::STATE_SET_PASSWORD
        ];

        foreach ($options as $option => $state) {
            if ($this->configuration->getOption($option) === null) {
                return $state;
            }
        }

        throw new Exception('Nothing to set up', 500);
    }
}