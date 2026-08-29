<?php

declare(strict_types=1);

namespace Liberu\Accounting\YearEnd\Actions;

use Liberu\Accounting\YearEnd\Enums\YearEndStatus;
use Liberu\Accounting\YearEnd\Exceptions\InvalidYearEnd;
use Liberu\Accounting\YearEnd\Models\YearEndClose;

final class LockYearEnd
{
    public function handle(YearEndClose $close): YearEndClose
    {
        if ($close->status !== YearEndStatus::Closed) {
            throw new InvalidYearEnd('Only closed year ends can be locked.');
        }
        $close->update(['status' => YearEndStatus::Locked, 'locked_at' => now()]);

        return $close->refresh();
    }
}
