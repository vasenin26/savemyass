<?php

namespace app\Service\Publisher;

use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\Storage\FileStorage;
use app\View\EmailTemplate;
use app\View\LayoutTemplate;

class DataPublisher implements Publisher
{

    public function __construct(private readonly MainConfiguration $configuration, private readonly FileStorage $fileStorage)
    {
    }

    public function getPublicPage(): \app\Http\Response\Response
    {

        $template = new LayoutTemplate('page/public', [
            'title' => I18n::get('protected.title'),
            ...$this->configuration->getOptions(),
            'files' => $this->fileStorage->getFiles(),
        ]);

        return new \app\Http\Response\HtmlPage($template);
    }

    public function publish(): void
    {
        if ($this->configuration->getOption(Configuration::PUBLISHED_OPTION)) {
            return;
        }

        $template = new EmailTemplate('email/notify', $this->configuration->getOptions());

        $emails = $this->configuration->getOption(Configuration::PUBLISH_OPTION_EMAILS);
        $emails = explode(';', $emails);

        foreach ($emails as $email) {
            mail($email, I18n::get('email.subject'), $template->getContent());
        }

        $this->configuration->setOption(Configuration::PUBLISHED_OPTION, 1);
        $this->configuration->save();
    }
}
