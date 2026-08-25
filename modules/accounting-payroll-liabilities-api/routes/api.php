<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\PayrollLiabilitiesApi\Http\Controllers\PayrollLiabilitiesController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/payroll-liabilities')->group(function (): void {
    Route::get('/', [PayrollLiabilitiesController::class, 'index']);
    Route::post('/', [PayrollLiabilitiesController::class, 'store']);
    Route::get('/{payrollLiability}', [PayrollLiabilitiesController::class, 'show']);
    Route::post('/{payrollLiability}/allocate', [PayrollLiabilitiesController::class, 'allocate']);
    Route::get('/summary', [PayrollLiabilitiesController::class, 'summary']);
});
