<?php

declare(strict_types=1);

namespace App\Service;

use App\Client\BinInfoClientInterface;
use App\DTO\Bin\BinInfo;

class BinInfoService
{
    public function __construct(private readonly BinInfoClientInterface $binInfoClient)
    {
    }

    public function get(string $bin): BinInfo
    {
        return $this->binInfoClient->getBinInfo($bin);
    }
}
