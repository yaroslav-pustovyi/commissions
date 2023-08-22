<?php

declare(strict_types=1);

namespace App;

use App\Factory\TransactionInputDataFactoryInterface;
use App\Service\CommissionsHandlerInterface;

class App
{
    public function __construct(
        private readonly CommissionsHandlerInterface $handler,
        private readonly TransactionInputDataFactoryInterface $transactionFactory
    ) {
    }

    public function run(array $data): float
    {
        $transaction = $this->transactionFactory->createFromArray($data);

        return $this->handler->handle($transaction)->getAmount() / 100;
    }
}
