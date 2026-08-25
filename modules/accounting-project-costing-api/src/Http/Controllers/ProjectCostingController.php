<?php

declare(strict_types=1);

namespace Liberu\Accounting\ProjectCostingApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\ProjectCosting\Actions\RecordProjectCost;
use Liberu\Accounting\ProjectCosting\Enums\CostType;
use Liberu\Accounting\ProjectCosting\Models\ProjectCost;
use Liberu\Accounting\ProjectCosting\Queries\ProjectCostSummary;

final class ProjectCostingController extends Controller
{
    public function index(): mixed
    {
        return ProjectCost::query()->with('projectJob')->latest('occurred_on')->paginate(min((int) request('per_page', 25), 100));
    }

    public function store(Request $request, RecordProjectCost $action): ProjectCost
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'project_job_id' => 'required|integer', 'type' => 'required|string|in:'.implode(',', array_column(CostType::cases(), 'value')), 'occurred_on' => 'nullable|date', 'amount' => 'required|numeric|min:0', 'currency' => 'required|string|size:3', 'committed' => 'nullable|boolean', 'actual' => 'nullable|boolean', 'wip_amount' => 'nullable|numeric|min:0', 'source_ref' => 'nullable|string', 'dimensions' => 'nullable|array', 'metadata' => 'nullable|array']));
    }

    public function show(ProjectCost $projectCost): ProjectCost
    {
        return $projectCost->load('projectJob');
    }

    public function summary(int $projectJobId, ProjectCostSummary $query): array
    {
        return $query->forProject($projectJobId);
    }
}
