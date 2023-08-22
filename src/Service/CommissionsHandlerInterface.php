<?php

namespace App\Service;

use App\DTO\TransactionInputData;
use Money\Money;

interface CommissionsHandlerInterface
{
    public function handle(TransactionInputData $transaction): Money;
}
