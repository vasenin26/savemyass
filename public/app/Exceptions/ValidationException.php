<?php

namespace app\Exceptions;

use TheSeer\Tokenizer\Exception;

class ValidationException extends Exception
{
    private array $errors = [];

    public function addError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isError(): bool
    {
        return !empty($this->errors);
    }
}
