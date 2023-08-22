<?php

declare(strict_types=1);

namespace App\DTO;

use Money\Money;

class TransactionInputData
{
    public function __construct(
        public readonly string $bin,
        public readonly Money $paidAmount
    ) {
    }
}
