<?php

namespace app\Http\Response;

use app\View\AbstractTemplate;

class HtmlPage extends AbstractTemplate implements Response
{
    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [];
    }
}