<?php

namespace app\Service\Configuration;

class Configuration
{
    public function getWizard(): Wizard
    {
        return new Wizard($this);
    }

    public function isPublish(): bool
    {
        return false;
    }

    public function isConfigured(): bool
    {
        return false;
    }

    public function getOption(string $key): null|string|bool
    {
        return false;
    }

    public function setOption(string $key, string|bool $value): void
    {

    }
}