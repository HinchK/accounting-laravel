<?php

declare(strict_types=1);

namespace Liberu\Accounting\FinancialMasterData\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Database\Eloquent\Model;

final readonly class MasterRecordCreated implements ShouldDispatchAfterCommit
{
    use Dispatchable;

    public function __construct(public Model $record) {}
}
