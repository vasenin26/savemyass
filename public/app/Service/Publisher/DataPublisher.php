<?php

namespace app\Service\Publisher;

use app\I18n\I18n;
use app\View\LayoutTemplate;

class DataPublisher implements Publisher
{
    public function getPublicPage(): \app\Http\Response\Response
    {
        $template = new LayoutTemplate('page/protected', [
            'title' => I18n::get('protected.title')
        ]);

        return new \app\Http\Response\HtmlPage($template);
    }

    public function publish(): void
    {

    }
}
