<?php

declare(strict_types=1);

use InvalidArgumentException;
use Liberu\Accounting\Core\ValueObjects\CurrencyCode;

it('accepts an ISO-style uppercase currency code', function (): void {
    expect(new CurrencyCode('GBP')->value)->toBe('GBP');
});

it('rejects malformed currency codes', function (string $code): void {
    new CurrencyCode($code);
})->with(['gbp', 'GB', 'GBPP'])->throws(InvalidArgumentException::class);
