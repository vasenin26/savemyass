<?php

namespace app\Storage;

interface Storage
{
    public function getOptions(): array;

    public function setOptions(array $options): void;

    public function getOption($key): string|int|bool|null;

    public function setOption($key, $value): void;

    public function save(): void;

    public function clear(): void;
}
