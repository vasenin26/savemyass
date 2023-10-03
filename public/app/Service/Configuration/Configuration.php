<?php

namespace app\Service\Configuration;

use ArrayAccess;

class Configuration implements ArrayAccess, MainConfiguration
{
    public const PASSWORD_OPTION_NAME = 'password';
    public const PUBLISH_OPTION_TIMESTAMP = 'publish_timestamp';
    public const PUBLISH_OPTION_EMAILS = 'emails';
    public const PUBLISH_OPTION_MESSAGE = 'message';
    public const PUBLISH_OPTION_FOR_ALL = 'for_all';
    public const PUBLISH_FILES_UPLOADED = 'files_uploaded';

    private const REQUIRE_OPTIONS = [
        self::PASSWORD_OPTION_NAME,
        self::PUBLISH_OPTION_TIMESTAMP,
        self::PUBLISH_OPTION_EMAILS,
        self::PUBLISH_OPTION_MESSAGE,
        self::PUBLISH_OPTION_FOR_ALL,
        self::PUBLISH_FILES_UPLOADED
    ];
    private array $options = [];

    public function __construct(private readonly \app\Storage\Storage $configuration)
    {
        $this->options = $this->configuration->getOptions();
    }

    public function isPublish(): bool
    {
        $publishTimestamp = $this->getOption(self::PUBLISH_OPTION_TIMESTAMP);

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

    public function setOption(string $key, string|bool|int|null $value): void
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

    public function getOptions(): array
    {
        return $this->options;
    }

    public function save(): void
    {
        $this->configuration->setOptions($this->options);
        $this->configuration->save();
    }
}
