<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\ProjectBillingApi\Http\Controllers\ProjectBillingController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/project-billing')->group(function (): void {
    Route::get('/', [ProjectBillingController::class, 'index']);
    Route::post('/', [ProjectBillingController::class, 'store']);
    Route::get('/{projectBilling}', [ProjectBillingController::class, 'show']);
    Route::post('/{projectBilling}/handoff', [ProjectBillingController::class, 'handoff']);
    Route::get('/project/{projectJobId}/summary', [ProjectBillingController::class, 'summary']);
});
