<?php
declare(strict_types=1);
namespace Liberu\AccountingSdk\Exception;
class ValidationException extends ApiException
{
    /** @param array<string, mixed> $validationErrors */
    public function __construct(string $message, protected array $validationErrors = [])
    {
        parent::__construct($message, 422);
    }

    /** @return array<string, mixed> */
    public function errors(): array
    {
        return $this->validationErrors;
    }
}
