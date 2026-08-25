<?php

declare(strict_types=1);

namespace Liberu\Accounting\ProjectBillingApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\ProjectBilling\Actions\HandoffProjectBilling;
use Liberu\Accounting\ProjectBilling\Actions\RecordProjectBilling;
use Liberu\Accounting\ProjectBilling\Enums\BillingMethod;
use Liberu\Accounting\ProjectBilling\Models\ProjectBilling;
use Liberu\Accounting\ProjectBilling\Queries\ProjectBillingSummary;

final class ProjectBillingController extends Controller
{
    public function index(): mixed
    {
        return ProjectBilling::query()->with('projectJob')->latest('period_start')->paginate(min((int) request('per_page', 25), 100));
    }

    public function store(Request $request, RecordProjectBilling $action): ProjectBilling
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'project_job_id' => 'required|integer', 'method' => 'required|string|in:'.implode(',', array_column(BillingMethod::cases(), 'value')), 'period_start' => 'nullable|date', 'period_end' => 'nullable|date', 'currency' => 'required|string|size:3', 'quantity' => 'nullable|numeric|min:0', 'rate' => 'nullable|numeric|min:0', 'amount' => 'nullable|numeric|min:0', 'progress_percent' => 'nullable|numeric|min:0|max:100', 'billable_time_amount' => 'nullable|numeric|min:0', 'billable_expense_amount' => 'nullable|numeric|min:0', 'retainer_amount' => 'nullable|numeric|min:0', 'write_up_down_amount' => 'nullable|numeric', 'source_ref' => 'nullable|string', 'metadata' => 'nullable|array']));
    }

    public function show(ProjectBilling $projectBilling): ProjectBilling
    {
        return $projectBilling->load('projectJob');
    }

    public function handoff(Request $request, ProjectBilling $projectBilling, HandoffProjectBilling $action): ProjectBilling
    {
        return $action->handle($projectBilling, $request->validate(['invoice_ref' => 'nullable|string'])['invoice_ref'] ?? null);
    }

    public function summary(int $projectJobId, ProjectBillingSummary $query): array
    {
        return $query->forProject($projectJobId);
    }
}
