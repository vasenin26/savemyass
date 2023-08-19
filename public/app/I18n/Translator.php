<?php

namespace app\I18n;

interface Translator
{
    public static function get(string $key, array $array = []): string;
}
