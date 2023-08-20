<?php

namespace app\Service\Publisher;

use app\I18n\I18n;

class DataPublisher implements Publisher
{
    public function getPublicPage(): \app\Http\Response\Response
    {
        return new \app\Http\Response\HtmlPage('page/protected', [
            'title' => I18n::get('protected.title')
        ]);
    }

    public function publish(): void
    {

    }
}
