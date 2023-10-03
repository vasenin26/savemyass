<?php

namespace app\Service\Configuration;

use app\Http\Request\HttpRequest;
use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\WizardAction\Congratulations;
use app\Service\Configuration\WizardAction\SetMessage;
use app\Service\Configuration\WizardAction\SetPassword;
use app\Service\Configuration\WizardAction\SetPublishOptions;
use app\Service\Configuration\WizardAction\UploadFiles;
use app\Service\Configuration\WizardAction\WizardAction;
use app\ServiceContainer;
use Exception;

class Wizard
{
    private const STATE_SET_PASSWORD = 0b000000000;
    private const STATE_SET_PUBLISH_OPTIONS = 0b000000001;
    private const STATE_UPLOAD_FILES = 0b000000010;
    private const STATE_MESSAGE_SET = 0b000000011;
    private const STATE_CONFIGURED = 'configured';
    public const CONFIGURED_OPTION_TO_STATE = [
        Configuration::PASSWORD_OPTION_NAME => self::STATE_SET_PASSWORD,
        Configuration::PUBLISH_OPTION_TIMESTAMP => self::STATE_SET_PUBLISH_OPTIONS,
        Configuration::PUBLISH_FILES_UPLOADED => self::STATE_UPLOAD_FILES,
        Configuration::PUBLISH_OPTION_MESSAGE => self::STATE_MESSAGE_SET
    ];

    private readonly WizardAction $state;

    public function __construct(private readonly ServiceContainer $serviceContainer, private readonly MainConfiguration $configuration, private readonly Request $request)
    {
        $this->state = $this->getAction();
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
    private function getAction(): WizardAction
    {
        $state = $this->getWizardState();
        return $this->getStateAction($state);
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
    private function getStateAction(?string $state): WizardAction
    {
        $actionClass = [
            self::STATE_SET_PASSWORD => SetPassword::class,
            self::STATE_SET_PUBLISH_OPTIONS => SetPublishOptions::class,
            self::STATE_UPLOAD_FILES => UploadFiles::class,
            self::STATE_CONFIGURED => Congratulations::class,
            self::STATE_MESSAGE_SET => SetMessage::class
        ][$state];

        return $this->serviceContainer->resolve($actionClass);
    }
}
