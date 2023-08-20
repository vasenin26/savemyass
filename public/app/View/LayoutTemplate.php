<?php

namespace app\View;

use app\I18n\I18n;
use app\Storage\Session;

abstract class LayoutTemplate extends \app\View\AbstractTemplate
{
    public const LAYOUT_FILE = 'layout';

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
