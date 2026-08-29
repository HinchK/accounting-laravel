<?php

declare(strict_types=1);

namespace Liberu\Accounting\YearEndApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\YearEnd\Actions\CloseYearEnd;
use Liberu\Accounting\YearEnd\Actions\CreateYearEndClose;
use Liberu\Accounting\YearEnd\Actions\LockYearEnd;
use Liberu\Accounting\YearEnd\Models\YearEndClose;

final class YearEndController extends Controller
{
    public function index(Request $request): mixed
    {
        return YearEndClose::query()->where('team_id', $this->teamId($request))->latest('fiscal_year')->paginate(min(max($request->integer('per_page', 25), 1), 100));
    }

    public function store(Request $request, CreateYearEndClose $action): mixed
    {
        return response()->json($action->handle([...$request->validate(['fiscal_year' => 'required|integer|min:2000|max:2200', 'period_end' => 'required|date', 'retained_earnings_account_ref' => 'required|string|max:160', 'net_income' => 'nullable|numeric', 'metadata' => 'nullable|array']), 'team_id' => $this->teamId($request)]), 201);
    }

    public function close(Request $request, string $close, CloseYearEnd $action): mixed
    {
        return $action->handle($this->closeForTeam($request, $close), (string) $request->validate(['closing_entry_ref' => 'required|string|max:160'])['closing_entry_ref']);
    }

    public function lock(Request $request, string $close, LockYearEnd $action): mixed
    {
        return $action->handle($this->closeForTeam($request, $close));
    }

    private function closeForTeam(Request $request, string $close): YearEndClose
    {
        return YearEndClose::query()->where('team_id', $this->teamId($request))->findOrFail($close);
    }

    private function teamId(Request $request): int
    {
        $teamId = $request->user()?->current_team_id;
        abort_if($teamId === null, 403, 'A team context is required.');

        return (int) $teamId;
    }
}
