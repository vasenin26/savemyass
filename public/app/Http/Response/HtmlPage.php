<?php

namespace app\Http\Response;

class HtmlPage implements Response
{
    private string $template;

    public function __construct(string $template) {
        $this->template = $template;
    }

    public function getContent(): string
    {
        return 'Hello';
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [];
    }
}