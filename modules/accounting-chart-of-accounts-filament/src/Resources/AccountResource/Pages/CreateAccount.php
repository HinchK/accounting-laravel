<?php

declare(strict_types=1);

namespace Liberu\Accounting\ChartOfAccountsFilament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Liberu\Accounting\ChartOfAccountsFilament\Resources\AccountResource;

final class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;
}
