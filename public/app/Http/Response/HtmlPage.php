<?php

namespace app\Http\Response;

use app\View\AbstractTemplate;

class HtmlPage implements Response
{
    public function __construct(private readonly AbstractTemplate $template)
    {
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [];
    }

    public function getContent(): string
    {
        return $this->template->getContent();
    }
}
