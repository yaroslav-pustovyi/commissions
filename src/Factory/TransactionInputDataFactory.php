<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\TransactionInputData;
use Money\Currency;
use Money\Money;

class TransactionInputDataFactory implements TransactionInputDataFactoryInterface
{
    public function createFromArray(array $data): TransactionInputData
    {
        return new TransactionInputData(
            $data['bin'],
            new Money((string)($data['amount'] * 100), new Currency($data['currency']))
        );
    }
}
