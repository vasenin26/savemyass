<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\HttpRequest;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Http\Request\Request;
use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\View\LayoutTemplate;
use Mockery\Exception;

class SetPassword extends LayoutTemplate implements WizardAction
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
        return new HtmlPage('wizard/password_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('set_password.title')
        ]);
    }

    private function saveForm(): Redirect
    {
        $password = $this->request->getPayload('password');
        $redirect = new Redirect('/wizard');

        if(empty($password)) {
            $redirect->setError('password', 'error.empty_password');
            return $redirect;
        }

        $this->configuration->setOption(Configuration::PASSWORD_OPTION_NAME, $password);
        $this->configuration->save();

        return $redirect;
    }
}
