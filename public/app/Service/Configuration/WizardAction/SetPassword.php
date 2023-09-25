<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Request\Request;
use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\Payload\PasswordFormPayload;
use app\View\LayoutTemplate;

class SetPassword implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request)
    {

    }

    public function showForm(): HtmlPage
    {
        $template = new LayoutTemplate('wizard/password_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('set_password.title')
        ]);
        return new HtmlPage($template);
    }

    public function saveForm(): Redirect
    {
        $payload = new PasswordFormPayload($this->request);

        if($payload->isValid()) {
            $this->configuration->setOption(Configuration::PASSWORD_OPTION_NAME, $payload->getPassword());
            $this->configuration->save();
        }

        return new Redirect('/wizard', $payload);
    }
}
