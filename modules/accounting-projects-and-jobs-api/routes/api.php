<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\ProjectsAndJobsApi\Http\Controllers\ProjectsAndJobsController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/projects-and-jobs')->group(function (): void {
    Route::get('/', [ProjectsAndJobsController::class, 'index']);
    Route::post('/', [ProjectsAndJobsController::class, 'store']);
    Route::get('/{project}', [ProjectsAndJobsController::class, 'show']);
    Route::post('/{project}/transition', [ProjectsAndJobsController::class, 'transition']);
});
