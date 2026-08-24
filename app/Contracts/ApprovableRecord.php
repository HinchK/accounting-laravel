<?php

declare(strict_types=1);

namespace App\Contracts;

interface ApprovableRecord
{
    public function markApproved(): void;

    public function markRejected(?string $reason): void;
}
