<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\ValueObjects;

use InvalidArgumentException;

final readonly class CurrencyCode
{
    public function __construct(public string $value)
    {
        if (preg_match('/^[A-Z]{3}$/', $value) !== 1) {
            throw new InvalidArgumentException('Currency codes must be three uppercase letters.');
        }
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
