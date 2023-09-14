<?php

namespace app\Storage;

class Session implements Configuration
{
    public const OPTION_LANG = 'lang';
    private array $options = [];

    private function __construct()
    {
        global $_SESSION;

        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        $this->options = $_SESSION ?? [];
    }

    public static function getInstance(): self
    {
        return new self();
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setOption($key, $value): void
    {
        $this->options[$key] = $value;
    }

    public function getOption($key): string|int|bool|null
    {
        return $this->options[$key] ?? null;
    }

    public function save(): void
    {
        global $_SESSION;

        foreach ($this->options as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function clear(): void
    {
        session_unset();
    }
}
