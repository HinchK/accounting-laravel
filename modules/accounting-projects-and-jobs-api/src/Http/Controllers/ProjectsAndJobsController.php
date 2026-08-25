<?php

declare(strict_types=1);

namespace Liberu\Accounting\ProjectsAndJobsApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\ProjectsAndJobs\Actions\CreateProjectJob;
use Liberu\Accounting\ProjectsAndJobs\Actions\TransitionProject;
use Liberu\Accounting\ProjectsAndJobs\Enums\ProjectStatus;
use Liberu\Accounting\ProjectsAndJobs\Models\ProjectJob;

final class ProjectsAndJobsController extends Controller
{
    public function index(): mixed
    {
        return ProjectJob::query()->with(['children', 'customer'])->latest()->paginate(25);
    }

    public function store(Request $request, CreateProjectJob $action): ProjectJob
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'customer_id' => 'nullable|integer', 'parent_id' => 'nullable|integer', 'name' => 'required|string', 'code' => 'nullable|string', 'description' => 'nullable|string', 'start_date' => 'nullable|date', 'end_date' => 'nullable|date', 'manager_ref' => 'nullable|string', 'budget_amount' => 'nullable|numeric|min:0', 'budget_currency' => 'nullable|string|size:3', 'dimensions' => 'nullable|array', 'source_links' => 'nullable|array']));
    }

    public function show(ProjectJob $project): ProjectJob
    {
        return $project->load(['children', 'customer']);
    }

    public function transition(Request $request, ProjectJob $project, TransitionProject $action): ProjectJob
    {
        return $action->handle($project, ProjectStatus::from($request->validate(['status' => 'required|string'])['status']));
    }
}
