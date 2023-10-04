<?php

namespace app\View;

use app\Storage\Session;

class EmailTemplate extends AbstractTemplate
{
    protected const LAYOUT_FILE = 'email';
    public function getContent(): string
    {
        $body = $this->parseTemplate($this->template, $this->data);
        return $this->parseTemplate(static::LAYOUT_FILE, [
            ...$this->data,
            'currentLanguage' => Session::getInstance()->getOption(Session::OPTION_LANG),
            'body' => $body
        ]);
    }
}