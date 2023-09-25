<?php

namespace app\Utils\Validator;

abstract class AbstractValidator
{
    const ERROR = null;

    public function __construct(protected mixed $value)
    {

    }

    abstract public function isValid(): bool;

    public function getError(): string
    {
        return static::ERROR;
    }
}