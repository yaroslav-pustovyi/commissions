<?php

namespace App\Factory;

use App\DTO\TransactionInputData;

interface TransactionInputDataFactoryInterface
{
    public function createFromArray(array $data): TransactionInputData;
}
