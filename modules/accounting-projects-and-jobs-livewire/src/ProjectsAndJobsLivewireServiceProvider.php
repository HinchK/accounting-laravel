<?php

declare(strict_types=1);

namespace Liberu\Accounting\ProjectsAndJobsLivewire;

use Illuminate\Support\ServiceProvider;

final class ProjectsAndJobsLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-accounting-projects-and-jobs');
    }
}
