<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Bin\BinInfo;
use App\DTO\TransactionInputData;
use Money\Money;

class CommissionsHandler implements CommissionsHandlerInterface
{
    public function __construct(
        private readonly BinInfoService $binInfoService,
        private readonly RateService $rateService,
        private readonly EUCountryChecker $euCountryChecker
    ) {
    }

    public function handle(TransactionInputData $transaction): Money
    {
        $binInfo = $this->binInfoService->get($transaction->bin);
        $rate = $this->rateService->getRateForCurrency($transaction->paidAmount->getCurrency()->getCode());

        $amntFixed = $transaction->paidAmount;
        if ($rate > 0) {
            $amntFixed = $amntFixed->divide((string)($rate));
        }

        return $amntFixed->multiply((string)$this->getMultiplier($binInfo));
    }

    private function getMultiplier(BinInfo $binInfo): float
    {
        /** @phpstan-ignore-next-line  */
        return $this->euCountryChecker->isEu($binInfo->getCountry()->getAlpha2()) ? 0.01 : 0.02;
    }
}
