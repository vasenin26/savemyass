<?php

namespace app\Http\Response;

use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\View\LayoutTemplate;

class ProtectedPage implements Response
{
    public function __construct(MainConfiguration $configuration)
    {
        $this->template = new LayoutTemplate(
            'page/protected',
            [
                'title' => I18n::get('protected.title'),
                'publishTime' => $configuration->getOption(Configuration::PUBLISH_OPTION_TIMESTAMP)
            ]
        );
    }

    public function getContent(): string
    {
        return $this->template->getContent();
    }

    public function getHeaders(): array
    {
        return [];
    }
}
