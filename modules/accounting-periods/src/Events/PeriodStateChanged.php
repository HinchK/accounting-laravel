<?php
declare(strict_types=1);
namespace Liberu\Accounting\Periods\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Liberu\Accounting\Periods\Models\AccountingPeriod;
use Liberu\Accounting\Periods\Enums\PeriodState;
final readonly class PeriodStateChanged { use Dispatchable; public function __construct(public AccountingPeriod $period, public PeriodState $from, public PeriodState $to) {} }
