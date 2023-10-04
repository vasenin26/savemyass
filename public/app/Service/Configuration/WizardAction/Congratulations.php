<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\I18n\I18n;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\Payload\CongratulationsFormPayload;
use app\Service\Configuration\WizardCommand\AbstractCommand;
use app\Service\Configuration\WizardCommand\NextCommand;
use app\Service\Configuration\WizardCommand\ResetCommand;
use app\Storage\Payload;
use app\View\LayoutTemplate;

class Congratulations implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request, readonly private Payload $payload)
    {

    }

    public function showForm(): HtmlPage
    {
        $template = new LayoutTemplate('wizard/congratulations', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('congratulations.title')
        ]);
        return new HtmlPage($template);
    }

    public function saveForm(): AbstractCommand
    {
        $payload = new CongratulationsFormPayload($this->request);

        if($payload->isReset()) {
            return new ResetCommand();
        }

        $this->configuration->setOption('success', 1);
        $this->configuration->save();

        return new NextCommand();
    }
}