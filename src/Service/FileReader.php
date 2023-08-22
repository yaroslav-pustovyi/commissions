<?php

declare(strict_types=1);

namespace App\Service;

use SplFileObject;

class FileReader
{
    public function readByLine(SplFileObject $file): \Generator
    {
        while (!$file->eof()) {
            yield $file->fgets();
        }
    }
}
