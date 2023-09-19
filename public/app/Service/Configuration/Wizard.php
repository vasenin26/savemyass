<?php

namespace app\Service\Configuration;

use app\Http\Request\HttpRequest;
use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\FullConfigured;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\SetPublishOptions;
use app\Service\Configuration\WizardAction\WizardAction;
use app\ServiceContainer;
use Exception;

class Wizard
{
    private const STATE_SET_PASSWORD = 0x0;
    private const STATE_SET_PUBLISH_OPTIONS = 0x1;
    private const STATE_CONFIGURED = 'configured';
    public const CONFIGURED_OPTION_TO_STATE = [
        Configuration::PASSWORD_OPTION_NAME => self::STATE_SET_PASSWORD,
        Configuration::PUBLISH_OPTION_TIMESTAMP => self::STATE_SET_PUBLISH_OPTIONS
    ];

    private readonly WizardAction $state;

    public function __construct(private readonly ServiceContainer $serviceContainer, private readonly MainConfiguration $configuration, private readonly Request $request)
    {
        $this->state = $this->getAction($request);
    }

    /**
     * @throws Exception
     */
    public function execute(): Response
    {
        return match ($this->request->getMethod()) {
            HttpRequest::METHOD_GET => $this->state->showForm(),
            HttpRequest::METHOD_POST => $this->state->saveForm(),
            default => throw new Exception('Method not allowed'),
        };
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
            self::STATE_SET_PUBLISH_OPTIONS => SetPublishOptions::class,
            self::STATE_CONFIGURED => FullConfigured::class
        ][$state];

        return $this->serviceContainer->resolve($actionClass);
    }
}
