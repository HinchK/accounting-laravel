<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\ReimbursementsApi\Http\Controllers\ReimbursementsController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/reimbursements')->group(function (): void {
    Route::get('/', [ReimbursementsController::class, 'index']);
    Route::post('/', [ReimbursementsController::class, 'store']);
    Route::post('/batches', [ReimbursementsController::class, 'batch']);
    Route::post('/batches/{batch}/status', [ReimbursementsController::class, 'status']);
    Route::post('/batches/{batch}/reconcile', [ReimbursementsController::class, 'reconcile']);
});
