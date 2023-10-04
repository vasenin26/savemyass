<?php

declare(strict_types=1);

namespace app\Utils\Converter;

use ErrorException;

class StringConverter
{
    public function convert(mixed $value): string
    {
        if ($value === true) {
            $value = "true";
        }

        if ($value === false) {
            $value = "false";
        }

        if (is_null($value)) {
            $value = "";
        }

        if (is_numeric($value)) {
            $value = (string)$value;
        }

        if (!is_string($value)) {
            throw new ErrorException("Unsupported type: " . get_class($value));
        }

        return $value;
    }

    public function extract(string|null $value): string|int|bool|null
    {
        if ($value === "true") {
            return true;
        }

        if ($value === "false") {
            return false;
        }

        if (is_numeric($value)) {
            return (int)$value;
        }

        if (is_null($value)) {
            return '';
        }

        if($value === "") {
            return null;
        }

        return $value;
    }
}
