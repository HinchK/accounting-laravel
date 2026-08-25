<?php

declare(strict_types=1);

namespace Liberu\Accounting\PayrollLiabilitiesApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\PayrollLiabilities\Actions\AllocatePayrollLiability;
use Liberu\Accounting\PayrollLiabilities\Actions\RecordPayrollLiability;
use Liberu\Accounting\PayrollLiabilities\Models\PayrollLiability;
use Liberu\Accounting\PayrollLiabilities\Queries\PayrollLiabilitySummary;

final class PayrollLiabilitiesController extends Controller
{
    public function index(): mixed
    {
        return PayrollLiability::query()->latest('due_on')->paginate(min((int) request('per_page', 25), 100));
    }

    public function store(Request $request, RecordPayrollLiability $action): PayrollLiability
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'agency_ref' => 'nullable|string', 'payee_ref' => 'nullable|string', 'liability_ref' => 'required|string|max:150', 'currency' => 'required|string|size:3', 'amount' => 'required|numeric|gt:0', 'paid_amount' => 'nullable|numeric|gte:0', 'due_on' => 'nullable|date', 'metadata' => 'nullable|array']));
    }

    public function show(PayrollLiability $payrollLiability): PayrollLiability
    {
        return $payrollLiability;
    }

    public function allocate(Request $request, PayrollLiability $payrollLiability, AllocatePayrollLiability $action): PayrollLiability
    {
        $data = $request->validate(['amount' => 'required|numeric|gt:0', 'allocation_ref' => 'required|string']);

        return $action->handle($payrollLiability, (float) $data['amount'], $data['allocation_ref']);
    }

    public function summary(Request $request, PayrollLiabilitySummary $query): array
    {
        return $query->forTeam($request->integer('team_id') ?: null);
    }
}
