<?php

declare(strict_types=1);

namespace Liberu\Accounting\PayrollIntegrationApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\PayrollIntegration\Actions\ImportPayrollRun;
use Liberu\Accounting\PayrollIntegration\Actions\MarkPayrollImport;
use Liberu\Accounting\PayrollIntegration\Enums\ImportStatus;
use Liberu\Accounting\PayrollIntegration\Models\PayrollImport;
use Liberu\Accounting\PayrollIntegration\Queries\PayrollImportSummary;

final class PayrollIntegrationController extends Controller
{
    public function index(): mixed
    {
        return PayrollImport::query()->latest()->paginate(min((int) request('per_page', 25), 100));
    }

    public function store(Request $request, ImportPayrollRun $action): PayrollImport
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'provider' => 'required|string|max:100', 'period_start' => 'required|date', 'period_end' => 'required|date', 'run_ref' => 'required|string|max:150', 'currency' => 'required|string|size:3', 'employee_refs' => 'nullable|array', 'contractor_refs' => 'nullable|array', 'dimensions' => 'nullable|array', 'project_refs' => 'nullable|array', 'adapter_ref' => 'nullable|string', 'metadata' => 'nullable|array']));
    }

    public function show(PayrollImport $payrollImport): PayrollImport
    {
        return $payrollImport;
    }

    public function status(Request $request, PayrollImport $payrollImport, MarkPayrollImport $action): PayrollImport
    {
        return $action->handle($payrollImport, ImportStatus::from($request->validate(['status' => 'required|string'])['status']));
    }

    public function summary(Request $request, PayrollImportSummary $query): array
    {
        return $query->forTeam($request->integer('team_id') ?: null);
    }
}
