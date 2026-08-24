<?php

declare(strict_types=1);

namespace Liberu\Accounting\FinancialMasterData\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Database\Eloquent\Model;

final readonly class MasterRecordCreated
{
    use Dispatchable;

    public function __construct(public Model $record) {}
}
