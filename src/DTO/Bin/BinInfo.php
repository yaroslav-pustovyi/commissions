<?php

namespace App\DTO\Bin;

use App\Exception\BinInfoValidationException;

class BinInfo
{
    private Country $country;

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    public static function fromArray(array $data): self
    {
        $bankInfo = new self();

        if (!isset($data['country']) || !is_array($data['country'])) {
            throw new BinInfoValidationException("'country' field is invalid");
        }
        $bankInfo->setCountry(Country::fromArray($data['country']));

        return $bankInfo;
    }
}
