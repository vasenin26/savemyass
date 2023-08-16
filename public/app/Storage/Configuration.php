<?php

namespace app\Storage;

interface Configuration
{
    public function __construct(string $fileName);

    public function getOptions(): array;

    public function setOptions(array $options): void;

    public function save(): void;

    public function clear(): void;
}