<?php

namespace app\Storage;

class Session implements Storage
{
    public const OPTION_LANG = 'lang';
    public const PAYLOAD_KEY = 'app_redirect_payload';
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

    public function setPayload(array $getPayload): void
    {
        $_SESSION[self::PAYLOAD_KEY] = $getPayload;
    }

    public function getPayload(): array
    {
        $payload = $_SESSION[self::PAYLOAD_KEY] ?? [];
        unset($_SESSION[self::PAYLOAD_KEY]);

        return $payload;
    }
}
