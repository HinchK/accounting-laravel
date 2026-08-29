<?php

use Illuminate\Support\Facades\Route;
use Liberu\Accounting\YearEndApi\Http\Controllers\YearEndController;

Route::prefix('api/v1/accounting/year-end')->middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/', [YearEndController::class, 'index'])->middleware('ability:accounting.year-end.read');
    Route::post('/', [YearEndController::class, 'store'])->middleware('ability:accounting.year-end.write');
    Route::post('/{close}/close', [YearEndController::class, 'close'])->middleware('ability:accounting.year-end.write');
    Route::post('/{close}/lock', [YearEndController::class, 'lock'])->middleware('ability:accounting.year-end.lock');
});
