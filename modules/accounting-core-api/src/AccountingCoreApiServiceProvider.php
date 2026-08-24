<?php

declare(strict_types=1);

namespace Liberu\Accounting\CoreApi;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Liberu\Accounting\Core\Models\LegalEntity;
use Liberu\Accounting\CoreApi\Policies\LegalEntityPolicy;

final class AccountingCoreApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(LegalEntity::class, LegalEntityPolicy::class);
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
