<?php

declare(strict_types=1);

namespace Liberu\Accounting\ReimbursementsApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\Reimbursements\Actions\CreatePaymentBatch;
use Liberu\Accounting\Reimbursements\Actions\CreateReimbursementLiability;
use Liberu\Accounting\Reimbursements\Actions\ReconcilePaymentBatch;
use Liberu\Accounting\Reimbursements\Actions\UpdatePaymentProviderStatus;
use Liberu\Accounting\Reimbursements\Models\ReimbursementBatch;
use Liberu\Accounting\Reimbursements\Models\ReimbursementLiability;

final class ReimbursementsController extends Controller
{
    public function index(): mixed
    {
        return ReimbursementLiability::query()->latest()->paginate(25);
    }

    public function store(Request $request, CreateReimbursementLiability $action): ReimbursementLiability
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'payee_ref' => 'required|string|max:190', 'source_type' => 'nullable|string|max:80', 'source_id' => 'nullable|string|max:190', 'kind' => 'nullable|string|max:24', 'currency' => 'required|string|size:3', 'amount' => 'required|numeric|min:0.01', 'metadata' => 'nullable|array']));
    }

    public function batch(Request $request, CreatePaymentBatch $action): ReimbursementBatch
    {
        return $action->handle($request->validate(['liability_ids' => 'required|array|min:1', 'liability_ids.*' => 'integer'])['liability_ids']);
    }

    public function status(Request $request, ReimbursementBatch $batch, UpdatePaymentProviderStatus $action): ReimbursementBatch
    {
        return $action->handle($batch, $request->validate(['status' => 'required|string', 'provider' => 'nullable|string', 'provider_ref' => 'nullable|string', 'failure_message' => 'nullable|string']));
    }

    public function reconcile(Request $request, ReimbursementBatch $batch, ReconcilePaymentBatch $action): mixed
    {
        return $action->handle($batch, (float) $request->validate(['settled_amount' => 'required|numeric', 'external_ref' => 'nullable|string'])['settled_amount'], $request->input('external_ref'));
    }
}
