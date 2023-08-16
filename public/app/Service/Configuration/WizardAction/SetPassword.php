<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\HttpRequest;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Http\Request\Request;
use app\Service\Configuration\Configuration;
use Mockery\Exception;

class SetPassword implements WizardAction
{
    public function __construct(private readonly Configuration $configuration, readonly private Request $request)
    {

    }

    public function execute(): Response
    {
        switch ($this->request->getMethod()) {
            case HttpRequest::METHOD_GET:
                return $this->showForm();
            case HttpRequest::METHOD_POST:
                return $this->setPassword();
            default:
                throw new Exception('Action Not Found', 404);
        }
    }

    private function showForm(): Response
    {
        return new HtmlPage('password_form', $this->configuration);
    }

    private function setPassword(): Response
    {
        return new Redirect();
    }
}