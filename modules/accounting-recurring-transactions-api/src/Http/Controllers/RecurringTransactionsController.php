<?php

declare(strict_types=1);

namespace Liberu\Accounting\RecurringTransactionsApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\RecurringTransactions\Actions\ApproveRecurringTemplate;
use Liberu\Accounting\RecurringTransactions\Actions\CreateRecurringTemplate;
use Liberu\Accounting\RecurringTransactions\Actions\GenerateRecurringOccurrences;
use Liberu\Accounting\RecurringTransactions\Models\RecurringTemplate;

final class RecurringTransactionsController extends Controller
{
    public function index(): mixed
    {
        return RecurringTemplate::query()->with('occurrences')->latest()->paginate(25);
    }

    public function store(Request $request, CreateRecurringTemplate $action): RecurringTemplate
    {
        return $action->handle($request->validate(['team_id' => 'nullable|integer', 'name' => 'required|string|max:255', 'transaction_type' => 'required|string|max:80', 'frequency' => 'required|string', 'starts_on' => 'required|date', 'next_run_on' => 'nullable|date', 'ends_on' => 'nullable|date', 'automatic' => 'boolean', 'date_rules' => 'nullable|array', 'amount_rules' => 'nullable|array', 'payload' => 'required|array', 'metadata' => 'nullable|array']));
    }

    public function show(RecurringTemplate $template): RecurringTemplate
    {
        return $template->load('occurrences');
    }

    public function approve(Request $request, RecurringTemplate $template, ApproveRecurringTemplate $action): RecurringTemplate
    {
        return $action->handle($template, $request->user()?->getAuthIdentifier());
    }

    public function generate(Request $request, RecurringTemplate $template, GenerateRecurringOccurrences $action): int
    {
        return $action->handle($template, (string) $request->validate(['through_date' => 'required|date'])['through_date']);
    }
}
