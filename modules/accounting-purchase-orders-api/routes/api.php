<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;use Liberu\Accounting\PurchaseOrdersApi\Http\Controllers\PurchaseOrdersController;
Route::middleware(['api','auth:sanctum','throttle:api'])->prefix('api/v1/accounting/purchase-orders')->group(function():void{Route::get('/',[PurchaseOrdersController::class,'index']);Route::post('/',[PurchaseOrdersController::class,'store']);Route::get('/{order}',[PurchaseOrdersController::class,'show']);Route::post('/{order}/transition',[PurchaseOrdersController::class,'transition']);Route::post('/{order}/receipts',[PurchaseOrdersController::class,'receipt']);Route::post('/{order}/changes',[PurchaseOrdersController::class,'change']);});
