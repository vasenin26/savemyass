<?php

namespace app\Utils\Validator;

class NotEmpty extends AbstractValidator
{
    const ERROR = 'error.field_is_empty';

    public function isValid(): bool
    {
        return !empty($this->value);
    }
}