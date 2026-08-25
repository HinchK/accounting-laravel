<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;use Liberu\Accounting\ReceiptManagementApi\Http\Controllers\ReceiptManagementController;
Route::middleware(['api','auth:sanctum','throttle:api'])->prefix('api/v1/accounting/receipt-management')->group(function():void{Route::get('/',[ReceiptManagementController::class,'index']);Route::post('/',[ReceiptManagementController::class,'store']);Route::get('/{receipt}',[ReceiptManagementController::class,'show']);Route::post('/{receipt}/match',[ReceiptManagementController::class,'match']);Route::post('/missing-requests',[ReceiptManagementController::class,'requestMissing']);});
