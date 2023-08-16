<?php

namespace app\View;

abstract class AbstractTemplate
{
    private $data = [];

    public function __construct(private readonly string $template, array|\ArrayAccess|null $data = null)
    {
        if (!is_null($data)) {
            $this->data = $data;
        }
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getContent(): string
    {
        ob_start();

        $content = ob_get_contents();
        ob_end_flush();

        return $content;
    }
}