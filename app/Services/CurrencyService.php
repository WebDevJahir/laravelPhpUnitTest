<?php

namespace App\Services;

class CurrencyService
{
    const RATES = [
        'usd' => [
            'eur' => 0.85,
            'gbp' => 0.75,
            'jpy' => 110.0,
        ]
    ];

    public function convert(float $amount, string $currencyFrom, string $currentTo): float
    {
        $rate = self::RATES[$currencyFrom][$currentTo] ?? 0;

        return round($amount * $rate, 2);
    }
}
