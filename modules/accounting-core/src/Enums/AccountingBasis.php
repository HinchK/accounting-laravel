<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\Enums;

enum AccountingBasis: string
{
    case Accrual = 'accrual';
    case Cash = 'cash';
}
