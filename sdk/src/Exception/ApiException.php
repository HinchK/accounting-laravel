<?php

declare(strict_types=1);

namespace Liberu\AccountingSdk\Exception;

use RuntimeException;

class ApiException extends RuntimeException
{
    public function __construct(string $message, protected int $httpStatus = 0)
    {
        parent::__construct($message, $httpStatus);
    }

    public function status(): int
    {
        return $this->httpStatus;
    }
}
