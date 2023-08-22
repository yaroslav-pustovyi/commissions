<?php

namespace App\DTO\Bin;

use App\Exception\BinInfoValidationException;

class Country
{
    private ?string $alpha2 = null;

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(?string $alpha2): void
    {
        $this->alpha2 = $alpha2;
    }

    public static function fromArray(array $data): self
    {
        $country = new self();

        if (!isset($data['alpha2']) || !is_string($data['alpha2'])) {
            throw new BinInfoValidationException("'alpha2' field is invalid");
        }

        $country->setAlpha2($data['alpha2']);

        return $country;
    }
}
