<?php

namespace app\Utils;

class ValidationErrors
{
    public function __construct(
        public readonly array $errors
    )
    {
    }

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->errors);
    }

    public function get(string $field): array
    {
        return $this->errors[$field];
    }
}