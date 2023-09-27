<?php

namespace app\Storage;

use app\Utils\Converter\StringConverter;
use ErrorException;

class StorageFile implements Storage
{
    private const DIRECTORY = '/data/';
    private array $options = [];

    public function __construct(private readonly string $fileName)
    {
        $this->loadOptions();
    }

    public function getOption($key): string|int|bool|null
    {
        return $this->options[$key];
    }

    public function setOption($key, $value): void
    {
        $this->options[$key] = $value;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    private function getPath()
    {
        return __DIR__ . self::DIRECTORY . $this->fileName;
    }

    private function loadOptions(): void
    {
        try {
            if(!file_exists($this->getPath())) {
                return;
            }

            $content = file_get_contents($this->getPath());
            $lines = explode("\n", $content);
        } catch (\Exception $e) {
            return;
        }

        $converter = new StringConverter();
        $this->options = [];

        foreach ($lines as $line) {
            $line = explode('=', $line);

            if(count($line) !== 2) {
                $line[] = null;
            }

            list($key, $value) = $line;

            $this->options[$key] = $converter->extract($value);
        }
    }

    public function save(): void
    {
        $converter = new StringConverter();
        $file = fopen($this->getPath(), 'w+');

        fwrite($file, implode("\n", array_map(function ($item) use ($converter) {
            $value = $this->options[$item];
            $value = $converter->convert($value);

            return "{$item}={$value}";
        }, array_keys($this->options))));

        fclose($file);
    }

    /**
     * @throws ErrorException
     */
    public function clear(): void
    {
        unlink($this->getPath());

        if(file_exists($this->getPath())) {
            throw new ErrorException('Cannot delete storage file');
        }
    }
}
