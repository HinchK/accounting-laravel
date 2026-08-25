<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\PayrollPaymentsApi\Http\Controllers\PayrollPaymentsController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/payroll-payments')->group(function (): void {
    Route::get('/', [PayrollPaymentsController::class, 'index']);
    Route::post('/', [PayrollPaymentsController::class, 'store']);
    Route::get('/{payrollPaymentBatch}', [PayrollPaymentsController::class, 'show']);
    Route::post('/{payrollPaymentBatch}/transition', [PayrollPaymentsController::class, 'transition']);
    Route::get('/summary', [PayrollPaymentsController::class, 'summary']);
});
