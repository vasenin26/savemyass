<?php

namespace app\Storage;

use function PHPUnit\Framework\stringStartsWith;

class FileStorage
{
    public function getFiles(): array
    {
        $dir = opendir('uploads');
        $files = [];

        while (($file = readdir($dir)) !== false) {
            if (str_starts_with($file, '.')) {
                continue;
            }

            $files[] = [
                'name' => $file,
                'url' => '/uploads/' . $file
            ];
        }

        return $files;
    }
}