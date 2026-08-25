<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;use Liberu\Accounting\ProjectCostingApi\Http\Controllers\ProjectCostingController;Route::middleware(['api','auth:sanctum','throttle:api'])->prefix('api/v1/accounting/project-costing')->group(function():void{Route::get('/',[ProjectCostingController::class,'index']);Route::post('/',[ProjectCostingController::class,'store']);Route::get('/{projectCost}',[ProjectCostingController::class,'show']);Route::get('/project/{projectJobId}/summary',[ProjectCostingController::class,'summary']);});
