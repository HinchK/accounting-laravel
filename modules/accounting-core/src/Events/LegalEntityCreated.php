<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Liberu\Accounting\Core\Models\LegalEntity;

final readonly class LegalEntityCreated
{
    use Dispatchable;

    public function __construct(public LegalEntity $legalEntity) {}
}
