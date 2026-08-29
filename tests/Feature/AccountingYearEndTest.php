<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Liberu\Accounting\YearEnd\Actions\CloseYearEnd;
use Liberu\Accounting\YearEnd\Actions\CreateYearEndClose;
use Liberu\Accounting\YearEnd\Actions\LockYearEnd;
use Liberu\Accounting\YearEnd\Enums\YearEndStatus;
use Liberu\Accounting\YearEnd\Exceptions\InvalidYearEnd;

uses(RefreshDatabase::class);

it('closes and locks a fiscal year', function (): void {
    $close = app(CreateYearEndClose::class)->handle(['team_id' => 21, 'fiscal_year' => 2025, 'period_end' => '2025-12-31', 'retained_earnings_account_ref' => 'retained-earnings', 'net_income' => 1250]);
    app(CloseYearEnd::class)->handle($close, 'closing-entry-1');
    app(LockYearEnd::class)->handle($close->fresh());

    expect($close->fresh()->status)->toBe(YearEndStatus::Locked)
        ->and($close->fresh()->closing_entry_ref)->toBe('closing-entry-1');
});

it('rejects an invalid fiscal year', function (): void {
    expect(fn (): mixed => app(CreateYearEndClose::class)->handle(['team_id' => 21, 'fiscal_year' => 1999, 'period_end' => '1999-12-31', 'retained_earnings_account_ref' => 'retained-earnings']))->toThrow(InvalidYearEnd::class);
});
