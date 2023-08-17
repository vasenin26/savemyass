<?php

namespace app\Service\Configuration;

use ArrayAccess;

class Configuration implements ArrayAccess
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

    public function isPublish(): bool
    {
        $publishTimestamp = $this->getOption(self::PUBLISH_OPTION_NAME);

        return $publishTimestamp < time();
    }

    public function isConfigured(): bool
    {
        foreach (self::REQUIRE_OPTIONS as $option) {
            if (!array_key_exists($option, $this->options)) {
                return false;
            }
        }

        return true;
    }

    public function isSet(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }

    public function getOption(string $key): null|string|bool
    {
        return $this->options[$key] ?? null;
    }

    public function setOption(string $key, string|bool $value): void
    {
        $this->options[$key] = $value;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->options[] = $value;
        } else {
            $this->options[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->options[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->options[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->options[$offset] ?? null;
    }
}