<?php

namespace app\Service\Configuration;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\FullConfigured;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\WizardAction;
use Exception;

class Wizard
{
    private const STATE_SET_PASSWORD = 'password_form';
    private const STATE_CONFIGURED = 'configured';
    public const CONFIGURED_OPTION_TO_STATE = [
        'password' => self::STATE_SET_PASSWORD,
    ];

    private readonly WizardAction $state;

    public function __construct(private readonly Configuration $configuration, Request $request)
    {
        $this->state = $this->getAction($request);
    }

    public function execute(): Response
    {
        return $this->state->execute();
    }

    /**
     * @throws Exception
     */
    private function getAction(Request $request): WizardAction
    {
        $state = $this->getWizardState();
        return $this->getStateAction($state, $request);
    }

    /**
     * @throws Exception
     */
    private function getWizardState(): ?string
    {
        if ($this->configuration->isConfigured()) {
            return self::STATE_CONFIGURED;
        }

        foreach (self::CONFIGURED_OPTION_TO_STATE as $option => $state) {
            if (!$this->configuration->isSet($option)) {
                return $state;
            }
        }

        return null;
    }

    /**
     * @throws Exception
     */
    private function getStateAction(?string $state, Request $request): WizardAction
    {
        $actionClass = [
            self::STATE_SET_PASSWORD => SetPassword::class,
            self::STATE_CONFIGURED => FullConfigured::class
        ][$state];

        return new $actionClass($this->configuration, $request);
    }
}
