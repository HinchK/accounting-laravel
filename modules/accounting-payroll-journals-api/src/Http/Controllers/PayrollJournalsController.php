<?php

declare(strict_types=1);

namespace Liberu\Accounting\PayrollJournalsApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\PayrollJournals\Actions\CreatePayrollJournal;
use Liberu\Accounting\PayrollJournals\Actions\PostPayrollJournal;
use Liberu\Accounting\PayrollJournals\Actions\ReversePayrollJournal;
use Liberu\Accounting\PayrollJournals\Models\PayrollJournal;
use Liberu\Accounting\PayrollJournals\Queries\PayrollJournalSummary;

final class PayrollJournalsController extends Controller
{
    public function index(): mixed
    {
        return PayrollJournal::query()->latest('payroll_period_end')->paginate(min((int) request('per_page', 25), 100));
    }

    public function store(Request $request, CreatePayrollJournal $action): PayrollJournal
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'journal_ref' => 'required|string|max:150', 'payroll_period_start' => 'required|date', 'payroll_period_end' => 'required|date', 'currency' => 'required|string|size:3', 'gross_pay' => 'required|numeric|gt:0', 'taxes' => 'nullable|numeric|gte:0', 'deductions' => 'nullable|numeric|gte:0', 'benefits' => 'nullable|numeric|gte:0', 'employer_costs' => 'nullable|numeric|gte:0', 'net_pay' => 'nullable|numeric|gte:0', 'liabilities' => 'nullable|array', 'allocation' => 'nullable|array', 'metadata' => 'nullable|array']));
    }

    public function show(PayrollJournal $payrollJournal): PayrollJournal
    {
        return $payrollJournal;
    }

    public function post(PayrollJournal $payrollJournal, PostPayrollJournal $action): PayrollJournal
    {
        return $action->handle($payrollJournal);
    }

    public function reverse(Request $request, PayrollJournal $payrollJournal, ReversePayrollJournal $action): PayrollJournal
    {
        return $action->handle($payrollJournal, $request->validate(['reversal_ref' => 'required|string'])['reversal_ref']);
    }

    public function summary(Request $request, PayrollJournalSummary $query): array
    {
        return $query->forTeam($request->integer('team_id') ?: null);
    }
}
