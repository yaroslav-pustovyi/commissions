<?php

declare(strict_types=1);

namespace Test\Unit\DTO\Bin;

use App\DTO\Bin\BinInfo;
use App\Exception\BinInfoValidationException;
use PHPUnit\Framework\TestCase;

class BinInfoTest extends TestCase
{
    public function testCreateFromArray(): void
    {
        $data = [
            'country' => [
                'alpha2' => 'LT',
            ]
        ];

        $binInfo = BinInfo::fromArray($data);

        $this->assertEquals('LT', $binInfo->getCountry()->getAlpha2());
    }

    public function testCreateFromArrayWithoutCountry(): void
    {
        $data = [];

        $this->expectException(BinInfoValidationException::class);

        BinInfo::fromArray($data);
    }

    public function testCreateFromArrayWithoutCountryCode(): void
    {
        $data = ['country' => []];

        $this->expectException(BinInfoValidationException::class);

        BinInfo::fromArray($data);
    }
}
