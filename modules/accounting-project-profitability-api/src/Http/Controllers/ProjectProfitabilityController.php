<?php

declare(strict_types=1);

namespace Liberu\Accounting\ProjectProfitabilityApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\ProjectProfitability\Actions\FinalizeProjectProfitability;
use Liberu\Accounting\ProjectProfitability\Actions\RecordProjectProfitability;
use Liberu\Accounting\ProjectProfitability\Models\ProjectProfitability;
use Liberu\Accounting\ProjectProfitability\Queries\ProjectProfitabilityDashboard;

final class ProjectProfitabilityController extends Controller
{
    public function index(): mixed
    {
        return ProjectProfitability::query()->with('projectJob')->latest('period_start')->paginate(min((int) request('per_page', 25), 100));
    }

    public function store(Request $request, RecordProjectProfitability $action): ProjectProfitability
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'project_job_id' => 'required|integer', 'period_start' => 'required|date', 'period_end' => 'required|date', 'currency' => 'required|string|size:3', 'revenue_amount' => 'nullable|numeric|min:0', 'cost_amount' => 'nullable|numeric|min:0', 'estimate_amount' => 'nullable|numeric|min:0', 'committed_amount' => 'nullable|numeric|min:0', 'actual_amount' => 'nullable|numeric|min:0', 'unbilled_wip_amount' => 'nullable|numeric|min:0', 'billed_amount' => 'nullable|numeric|min:0', 'dimensions' => 'nullable|array', 'source_links' => 'nullable|array', 'metadata' => 'nullable|array']));
    }

    public function show(ProjectProfitability $projectProfitability): ProjectProfitability
    {
        return $projectProfitability->load('projectJob');
    }

    public function finalize(ProjectProfitability $projectProfitability, FinalizeProjectProfitability $action): ProjectProfitability
    {
        return $action->handle($projectProfitability);
    }

    public function dashboard(int $projectJobId, ProjectProfitabilityDashboard $query): array
    {
        return $query->forProject($projectJobId);
    }
}
