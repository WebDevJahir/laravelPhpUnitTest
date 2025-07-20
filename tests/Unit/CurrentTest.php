<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use PHPUnit\Framework\TestCase;

class CurrentTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_convert_usd_to_eur_success(): void
    {
        $result = (new CurrencyService())->convert(100, 'usd', 'eur');
        $this->assertEquals(85.00, $result);
    }
}
