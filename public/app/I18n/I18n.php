<?php

namespace app\I18n;

class I18n implements Translator
{
    private static ?I18n $instance = null;
    private static array $translations;

    private function __construct(string $lang)
    {
        self::$translations = include(__DIR__ . "/Translation/{$lang}.php");
    }

    public static function setLanguage(string $lang): I18n
    {
        return self::$instance = new self($lang);
    }

    public static function get(string $key, array $array = []): string
    {
        return self::$translations[$key] ?? $key;
    }
}
