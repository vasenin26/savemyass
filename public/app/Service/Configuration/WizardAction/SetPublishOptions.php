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

class SetPublishOptions extends LayoutTemplate implements WizardAction
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
        $delay = $this->request->getPayload('delay');
        $redirect = new Redirect('/wizard');

        if(empty($delay)) {
            $redirect->setError('delay', 'error.empty_password');
            return $redirect;
        }

        $this->configuration->setOption(Configuration::PUBLISH_OPTION_NAME, $delay);
        $this->configuration->save();

        return $redirect;
    }
}
