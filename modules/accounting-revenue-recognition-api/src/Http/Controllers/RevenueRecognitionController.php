<?php

declare(strict_types=1);

namespace Liberu\Accounting\RevenueRecognitionApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\RevenueRecognition\Actions\CreateRevenueSchedule;
use Liberu\Accounting\RevenueRecognition\Actions\ModifyRevenueSchedule;
use Liberu\Accounting\RevenueRecognition\Actions\RecognizeDueRevenue;
use Liberu\Accounting\RevenueRecognition\Actions\ReconcileRevenueRun;
use Liberu\Accounting\RevenueRecognition\Models\RevenueRecognitionRun;
use Liberu\Accounting\RevenueRecognition\Models\RevenueSchedule;
use Liberu\Accounting\RevenueRecognitionApi\Http\Resources\RevenueScheduleResource;

final class RevenueRecognitionController extends Controller
{
    public function index(): mixed
    {
        return RevenueSchedule::query()->latest()->paginate(25);
    }

    public function store(Request $request, CreateRevenueSchedule $action): RevenueScheduleResource
    {
        return new RevenueScheduleResource($action->handle($request->validate(['team_id' => 'nullable|integer', 'source_type' => 'nullable|string|max:80', 'source_id' => 'nullable|string|max:190', 'description' => 'nullable|string', 'currency' => 'required|string|size:3', 'total_amount' => 'required|numeric|min:0', 'start_date' => 'required|date', 'periods' => 'required|integer|min:1', 'deferred_account_ref' => 'required|string|max:190', 'revenue_account_ref' => 'required|string|max:190', 'funded' => 'boolean', 'metadata' => 'nullable|array'])));
    }

    public function show(RevenueSchedule $schedule): RevenueScheduleResource
    {
        return new RevenueScheduleResource($schedule->load(['entries', 'modifications']));
    }

    public function recognize(Request $request, RevenueSchedule $schedule, RecognizeDueRevenue $action): mixed
    {
        $data = $request->validate(['as_of_date' => 'required|date', 'team_id' => 'nullable|integer']);

        return $action->handle($schedule, $data['as_of_date'], $data['team_id'] ?? null);
    }

    public function modify(Request $request, RevenueSchedule $schedule, ModifyRevenueSchedule $action): mixed
    {
        return $action->handle($schedule, $request->validate(['effective_date' => 'nullable|date', 'amount_delta' => 'required|numeric', 'reason' => 'required|string', 'metadata' => 'nullable|array']));
    }

    public function reconcile(Request $request, RevenueRecognitionRun $run, ReconcileRevenueRun $action): mixed
    {
        return $action->handle($run, $request->validate(['references' => 'required|array'])['references']);
    }
}
