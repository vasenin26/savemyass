<?php

namespace app\Service\Configuration;

class Configuration
{

    private const PUBLISH_OPTION_NAME = 'publish_timestamp';

    private const REQUIRE_OPTIONS = [
        'password',
        self::PUBLISH_OPTION_NAME
    ];
    private $options = [];

    public function __construct(private readonly \app\Storage\Configuration $configuration)
    {
        $this->options = $this->configuration->getOptions();
    }

    public function getWizard(): Wizard
    {
        return new Wizard($this);
    }

    public function isPublish(): bool
    {
        $publishTimestamp = $this->getOption(self::PUBLISH_OPTION_NAME);

        return $publishTimestamp < time();
    }

    public function isConfigured(): bool
    {
        foreach (self::REQUIRE_OPTIONS as $option) {
            if(!array_key_exists($option, $this->options)) {
                return false;
            }
        }

        return true;
    }

    public function getOption(string $key): null|string|bool
    {
        return $this->options[$key];
    }

    public function setOption(string $key, string|bool $value): void
    {
        $this->options[$key] = $value;
    }
}