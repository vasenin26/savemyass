<?php

namespace Utils;

use app\Storage\Storage;
use app\Storage\Session;

class FakeSession extends Session implements Storage
{
    private array $options = [];

    public function __construct()
    {
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
    }

    public function clear(): void
    {
        $this->options = [];
    }
}
