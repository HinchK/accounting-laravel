<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;use Liberu\Accounting\PurchaseRequisitionsApi\Http\Controllers\PurchaseRequisitionsController;
Route::middleware(['api','auth:sanctum','throttle:api'])->prefix('api/v1/accounting/purchase-requisitions')->group(function():void{Route::get('/',[PurchaseRequisitionsController::class,'index']);Route::post('/',[PurchaseRequisitionsController::class,'store']);Route::get('/{requisition}',[PurchaseRequisitionsController::class,'show']);Route::post('/{requisition}/transition',[PurchaseRequisitionsController::class,'transition']);Route::post('/{requisition}/approve',[PurchaseRequisitionsController::class,'approve']);});
