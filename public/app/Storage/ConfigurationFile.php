<?php

namespace app\Storage;

class ConfigurationFile implements Configuration
{
    private const DIRECTORY = '/';
    private array $options = [];

    public function __construct(private readonly string $fileName)
    {
        $this->loadOptions();
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

        $this->options = [];

        foreach ($lines as $line) {
            $line = explode('=', $line);

            if(count($line) !== 2) {
                $line[] = null;
            }

            list($key, $value) = $line;

            if ($value === "true") {
                $value = true;
            }
            if ($value === "false") {
                $value = false;
            }
            if (is_numeric($value)) {
                $value = (int)$value;
            }

            $this->options[$key] = $value;
        }
    }

    public function save(): void
    {

        $file = fopen($this->getPath(), 'w+');

        fwrite($file, implode("\n", array_map(function ($item) {
            $value = $this->options[$item];

            if ($value === true) {
                $value = "true";
            }
            if ($value === false) {
                $value = "false";
            }

            return "{$item}={$value}";
        }, array_keys($this->options))));

        fclose($file);
    }

    public function clear(): void
    {
        unlink($this->getPath());
    }
}
