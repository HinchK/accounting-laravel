<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Liberu\Accounting\SalesTaxAndGstApi\Http\Controllers\SalesTaxController;

Route::middleware(['api', 'auth:sanctum', 'throttle:api'])->prefix('api/v1/accounting/sales-tax-and-gst')->group(function (): void {
    Route::get('/', [SalesTaxController::class, 'index']);
    Route::post('/', [SalesTaxController::class, 'store']);
    Route::get('/{record}', [SalesTaxController::class, 'show']);
    Route::post('/{record}/activate', [SalesTaxController::class, 'activate']);
    Route::post('/{record}/close', [SalesTaxController::class, 'close']);
});
