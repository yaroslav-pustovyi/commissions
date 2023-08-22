<?php

declare(strict_types=1);

namespace Test\Unit\Service;

use App\Service\EUCountryChecker;
use PHPUnit\Framework\TestCase;

class EUCountryCheckerTest extends TestCase
{
    private const COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    private EUCountryChecker $countryChecker;

    public function setUp(): void
    {
        $this->countryChecker = new EUCountryChecker();
    }

    public function testIsEu(): void
    {
        foreach (self::COUNTRIES as $country) {
            $this->assertTrue($this->countryChecker->isEu($country));
        }

        $this->assertFalse($this->countryChecker->isEu('US'));
    }
}
