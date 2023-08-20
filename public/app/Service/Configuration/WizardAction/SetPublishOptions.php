<?php

namespace app\Service\Configuration\WizardAction;

use app\Exceptions\ValidationException;
use app\Http\Request\HttpRequest;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Http\Request\Request;
use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use Mockery\Exception;

class SetPublishOptions implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request)
    {

    }

    public function execute(): Response
    {
        return match ($this->request->getMethod()) {
            HttpRequest::METHOD_GET => $this->showForm(),
            HttpRequest::METHOD_POST => $this->saveForm(),
            default => throw new Exception('Action Not Found', 404),
        };
    }

    private function showForm(): Response
    {
        return new HtmlPage('wizard/publish_options_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('publish_options.title')
        ]);
    }

    private function saveForm(): Redirect
    {

        $redirect = new Redirect('/wizard');

        try {
            list($delay, $emails, $forAll) = $this->getPayload($this->request);
        } catch (ValidationException $exception) {
            foreach ($exception->getErrors() as $field => $error) {
                $redirect->setError($field, $error);
            }

            return $redirect;
        }

        $this->configuration->setOption(Configuration::PUBLISH_OPTION_TIMESTAMP, time() + $delay * 60 * 60 * 24);
        $this->configuration->setOption(Configuration::PUBLISH_OPTION_EMAILS, $emails);
        $this->configuration->setOption(Configuration::PUBLISH_OPTION_FOR_ALL, $forAll);

        $this->configuration->save();

        return $redirect;
    }

    /**
     * @throws ValidationException
     */
    private function getPayload(Request $request): array
    {
        $exception = new ValidationException();

        $delay = $request->getPayload('delay');
        $emails = $request->getPayload('emails');
        $forAll = $request->getPayload('for_all');

        if (empty($delay)) {
            $exception->addError('delay', 'error.empty_delay');
        }

        if (is_null($emails)) {
            $exception->addError('emails', 'error.emails_not_set');
        }

        if ($exception->isError()) {
            throw $exception;
        }

        return [$delay, $emails, $forAll];
    }
}
