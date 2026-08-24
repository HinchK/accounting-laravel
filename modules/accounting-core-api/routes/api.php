<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Liberu\Accounting\CoreApi\Http\Controllers\LegalEntityController;

Route::prefix('api/v1/accounting/accounting-core')
    ->middleware(['auth:sanctum', 'throttle:60,1'])
    ->group(function (): void {
        Route::get('legal-entities', [LegalEntityController::class, 'index'])
            ->middleware('ability:accounting.core.read');
        Route::get('legal-entities/{legalEntity}', [LegalEntityController::class, 'show'])
            ->middleware('ability:accounting.core.read');
        Route::post('legal-entities', [LegalEntityController::class, 'store'])
            ->middleware('ability:accounting.core.write');
    });
