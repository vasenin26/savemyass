<?php

namespace app\I18n;

class I18n implements Translator
{
    private static ?I18n $instance = null;
    private static array $translations;

    private function __construct(string $lang)
    {
        self::$translations = self::extractTranslations($lang);
    }

    public static function getTranslations(string $lang): I18n
    {
        return self::$instance = new self($lang);
    }

    public static function get(string $key, array $array = []): string
    {
        return self::$translations[$key] ?? $key;
    }

    public static function getAvailableLanguages(): array
    {
        $dir = opendir(__DIR__ . "/Translation");
        $languages = [];

        while (($file = readdir($dir)) !== false) {
            if ($file != "." && $file != "..") {
                $lang = substr($file, 0, -4);
                $translations = self::extractTranslations($lang);
                $languages[$lang] = $translations['lang'] ?? null;
            }
        }

        ksort($languages);

        return $languages;
    }

    private static function extractTranslations($lang): array
    {
        return include(__DIR__ . "/Translation/{$lang}.php");
    }
}
