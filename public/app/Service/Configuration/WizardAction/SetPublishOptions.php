<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Request\Request;
use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\Payload\PublishOptionsFormPayload;
use app\Storage\Payload;
use app\View\LayoutTemplate;

class SetPublishOptions implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request, readonly private Payload $payload)
    {

    }

    public function showForm(): HtmlPage
    {
        $template = new LayoutTemplate('wizard/publish_options_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('publish_options.title'),
            'errors' => $this->payload->getErrors(),
        ]);

        return new HtmlPage($template);
    }

    public function saveForm(): Redirect
    {
        $payload = new PublishOptionsFormPayload($this->request);

        if($payload->isValid()) {
            $this->configuration->setOption(Configuration::PUBLISH_OPTION_TIMESTAMP, time() + $payload->getDelay() * 60 * 60 * 24);
            $this->configuration->setOption(Configuration::PUBLISH_OPTION_EMAILS, $payload->getEmails());
            $this->configuration->setOption(Configuration::PUBLISH_OPTION_FOR_ALL, $payload->isForAll());

            $this->configuration->save();
        }

        return new Redirect('/wizard', $payload);
    }
}
