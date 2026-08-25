<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\RecurringTransactionsApi\Http\Controllers\RecurringTransactionsController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/recurring-transactions')->group(function (): void {
    Route::get('/', [RecurringTransactionsController::class, 'index']);
    Route::post('/', [RecurringTransactionsController::class, 'store']);
    Route::get('/{template}', [RecurringTransactionsController::class, 'show']);
    Route::post('/{template}/approve', [RecurringTransactionsController::class, 'approve']);
    Route::post('/{template}/generate', [RecurringTransactionsController::class, 'generate']);
});
