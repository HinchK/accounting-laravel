<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\SalesOrdersApi\Http\Controllers\SalesOrderController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/sales-orders')->group(function (): void {
    Route::get('/', [SalesOrderController::class, 'index']);
    Route::post('/', [SalesOrderController::class, 'store']);
    Route::get('/{salesOrder}', [SalesOrderController::class, 'show']);
    Route::post('/{salesOrder}/transition', [SalesOrderController::class, 'transition']);
    Route::post('/{salesOrder}/deposits', [SalesOrderController::class, 'deposit']);
    Route::post('/{salesOrder}/invoice', [SalesOrderController::class, 'invoice']);
});
