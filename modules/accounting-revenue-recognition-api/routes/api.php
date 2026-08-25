<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;use Liberu\Accounting\RevenueRecognitionApi\Http\Controllers\RevenueRecognitionController;
Route::middleware(['api','auth:sanctum','throttle:api'])->prefix('api/v1/accounting/revenue-recognition')->group(function():void{Route::get('/',[RevenueRecognitionController::class,'index']);Route::post('/',[RevenueRecognitionController::class,'store']);Route::get('/{schedule}',[RevenueRecognitionController::class,'show']);Route::post('/{schedule}/recognize',[RevenueRecognitionController::class,'recognize']);Route::post('/{schedule}/modify',[RevenueRecognitionController::class,'modify']);Route::post('/runs/{run}/reconcile',[RevenueRecognitionController::class,'reconcile']);});
