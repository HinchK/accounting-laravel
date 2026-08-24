<?php
declare(strict_types=1);
namespace Liberu\Accounting\FinancialStatementsApi;
use Illuminate\Support\ServiceProvider; use Illuminate\Support\Facades\Gate; use Liberu\Accounting\FinancialStatementsApi\Policies\FinancialStatementsPolicy;
final class FinancialStatementsApiServiceProvider extends ServiceProvider { public function boot():void{$this->loadRoutesFrom(__DIR__.'/../routes/api.php');Gate::define('accounting.financial-statements.view',fn($user)=>$user!==null&&method_exists($user,'tokenCan')&&$user->tokenCan('accounting.financial-statements.read'));} }
