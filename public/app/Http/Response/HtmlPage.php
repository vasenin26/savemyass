<?php

namespace app\Http\Response;

use app\View\AbstractTemplate;
use app\View\LayoutTemplate;

class HtmlPage extends LayoutTemplate implements Response
{
    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [];
    }
}
