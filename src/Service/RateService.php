<?php

declare(strict_types=1);

namespace App\Service;

use App\Client\RateClientInterface;
use App\Exception\RateNotFoundException;

class RateService
{
    public function __construct(private readonly RateClientInterface $rateClient)
    {
    }

    public function getRates(): array
    {
        return $this->rateClient->getRates();
    }

    /**
     * @throws RateNotFoundException
     */
    public function getRateForCurrency(string $currencyCode): float
    {
        $rate = $this->getRates()[$currencyCode] ?? null;
        if ($rate === null) {
            throw new RateNotFoundException(sprintf("Unable to find rate for '%s' currency code", $currencyCode));
        }

        return $rate;
    }
}
