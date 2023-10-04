<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Request\Request;
use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\Payload\MessageFormPayload;
use app\Service\Configuration\Payload\PasswordFormPayload;
use app\Service\Configuration\WizardCommand\NextCommand;
use app\View\LayoutTemplate;

class SetMessage implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request)
    {

    }

    public function showForm(): HtmlPage
    {
        $template = new LayoutTemplate('wizard/message_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('set_message.title')
        ]);
        return new HtmlPage($template);
    }

    public function saveForm(): \app\Service\Configuration\WizardCommand\AbstractCommand
    {
        $payload = new MessageFormPayload($this->request);

        if($payload->isValid()) {
            $this->configuration->setOption(Configuration::PUBLISH_MESSAGE, $payload->getMessage());
            $this->configuration->save();
        }

        return new NextCommand();
    }
}
