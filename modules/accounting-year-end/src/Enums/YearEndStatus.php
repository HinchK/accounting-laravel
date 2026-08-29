<?php

declare(strict_types=1);

namespace Liberu\Accounting\YearEnd\Enums;

enum YearEndStatus: string
{
    case Open = 'open';
    case Closed = 'closed';
    case Locked = 'locked';
    case Reopened = 'reopened';
}
