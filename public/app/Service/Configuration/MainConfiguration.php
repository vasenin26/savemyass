<?php

namespace app\Service\Configuration;

interface MainConfiguration
{
    public function isPublish(): bool;
    public function isConfigured(): bool;

    public function getOptions(): array;

    public function setOption(string $key, string|int|bool|null $value): void;

    public function save(): void;
}
