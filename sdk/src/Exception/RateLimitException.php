<?php

declare(strict_types=1);

namespace Liberu\AccountingSdk\Exception;

class RateLimitException extends ApiException
{
    public function __construct(string $message, protected int $retryAfter = 0)
    {
        parent::__construct($message, 429);
    }

    public function retryAfter(): int
    {
        return $this->retryAfter;
    }
}
