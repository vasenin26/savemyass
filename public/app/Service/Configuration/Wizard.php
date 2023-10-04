<?php

namespace app\Service\Configuration;

use app\Http\Request\HttpRequest;
use app\Http\Request\Request;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\Congratulations;
use app\Service\Configuration\WizardAction\SetMessage;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\SetPublishOptions;
use app\Service\Configuration\WizardAction\UploadFiles;
use app\Service\Configuration\WizardAction\WizardAction;
use app\Service\Configuration\WizardCommand\AbstractCommand;
use app\ServiceContainer;
use app\Storage\Session;
use Exception;

class Wizard
{
    private const STATE_SET_PASSWORD = 0b000000000;
    private const STATE_SET_PUBLISH_OPTIONS = 0b000000001;
    private const STATE_UPLOAD_FILES = 0b000000010;
    private const STATE_MESSAGE_SET = 0b000000011;
    private const STATE_CONFIGURED = 0b000000100;
    public const CONFIGURED_OPTION_ORDER = [
        self::STATE_SET_PASSWORD,
        self::STATE_UPLOAD_FILES,
        self::STATE_MESSAGE_SET,
        self::STATE_SET_PUBLISH_OPTIONS,
        self::STATE_CONFIGURED,
    ];
    public const STATE_SESSION_KEY_NAME = 'configuration_wizard_state';

    private readonly ?WizardAction $state;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly ServiceContainer  $serviceContainer,
        private readonly MainConfiguration $configuration,
        private readonly Request           $request,
        private readonly Session           $session
    ) {
        $this->state = $this->getAction();
    }

    /**
     * @throws Exception
     */
    public function execute(): Response
    {
        if($this->state === null) {
            $this->reset();
            return new Redirect('/');
        }

        return $this->routeAction()->execute($this);
    }

    private function routeAction(): AbstractCommand
    {
        return match ($this->request->getMethod()) {
            HttpRequest::METHOD_GET => $this->state->showForm(),
            HttpRequest::METHOD_POST => $this->state->saveForm(),
            default => throw new Exception('Method not allowed')
        };
    }

    /**
     * @throws Exception
     */
    private function getAction(): ?WizardAction
    {
        $state = $this->getWizardState();

        if (is_null($state)) {
            return null;
        }

        return $this->getStateAction($state);
    }

    /**
     * @throws Exception
     */
    private function getWizardState(): ?int
    {
        $stateNumber = $this->session->getOption(self::STATE_SESSION_KEY_NAME) ?? 0;
        return self::CONFIGURED_OPTION_ORDER[$stateNumber] ?? null;
    }

    /**
     * @throws Exception
     */
    private function getStateAction(?int $state): WizardAction
    {
        $actionClass = [
            self::STATE_SET_PASSWORD => SetPassword::class,
            self::STATE_UPLOAD_FILES => UploadFiles::class,
            self::STATE_MESSAGE_SET => SetMessage::class,
            self::STATE_SET_PUBLISH_OPTIONS => SetPublishOptions::class,
            self::STATE_CONFIGURED => Congratulations::class,
        ][$state];

        return $this->serviceContainer->resolve($actionClass);
    }

    public function next(): void
    {
        $this->session->setOption(self::STATE_SESSION_KEY_NAME, $this->getNextStep());
        $this->session->save();
    }

    public function reset(): void
    {
        $this->configuration->isConfigured();
        $this->session->setOption(self::STATE_SESSION_KEY_NAME, $this->getFirstStep());
        $this->session->save();
    }

    private function getNextStep(): int
    {
        return $this->session->getOption(self::STATE_SESSION_KEY_NAME) + 1;
    }

    private function getFirstStep(): int
    {
        return self::CONFIGURED_OPTION_ORDER[0];
    }
}
