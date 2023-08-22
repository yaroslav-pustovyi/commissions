<?php

namespace App\Client;

use App\DTO\Bin\BinInfo;

interface BinInfoClientInterface
{
    public function getBinInfo(string $bin): BinInfo;
}
