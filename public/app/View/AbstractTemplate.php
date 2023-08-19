<?php

namespace app\View;

abstract class AbstractTemplate
{
    protected array $data = [];

    public function __construct(protected readonly string $template, ?array $data = null)
    {
        if (!is_null($data)) {
            $this->data = $data;
        }
    }

    public function setData(array $data): void
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

    protected function getTemplatePath($template): string
    {
        return __DIR__ . '/templates/' . $template . '.php';
    }

    protected function parseTemplate(string $template, ?array $data = null): string
    {
        extract($data ?? []);

        ob_start();

        include(static::getTemplatePath($template));
        $content = ob_get_contents();

        ob_clean();

        return $content;
    }

}
