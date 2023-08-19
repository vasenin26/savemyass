<?php

namespace app\View;

abstract class LayoutTemplate extends \app\View\AbstractTemplate
{
    public const LAYOUT_FILE = 'layout';

    public function getContent(): string
    {
        $body = $this->parseTemplate($this->template, $this->data);
        return $this->parseTemplate(static::LAYOUT_FILE, [...$this->data, 'body' => $body]);
    }

}
