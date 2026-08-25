<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\AccountsPayable\Actions\ApplyPayment;
use Liberu\Accounting\AccountsPayable\Actions\CreateOpenItem;
use Liberu\Accounting\AccountsPayable\Actions\RecordPayment;
use Liberu\Accounting\AccountsPayable\Enums\PayableStatus;
use Liberu\Accounting\AccountsPayable\Queries\AgingQuery;
use Liberu\Accounting\FinancialMasterData\Enums\PartyType;
use Liberu\Accounting\FinancialMasterData\Models\Party;

uses(RefreshDatabase::class);

it('reconciles supplier open items, payments, and aging', function (): void {
    $party = payableParty();
    $item = app(CreateOpenItem::class)->handle([
        'party_id' => $party->id, 'reference' => 'BILL-AP-1', 'issued_on' => '2026-08-01', 'due_on' => '2026-08-10',
        'original_amount' => 250, 'currency' => 'USD',
    ]);
    $payment = app(RecordPayment::class)->handle([
        'party_id' => $party->id, 'paid_on' => '2026-08-05', 'amount' => 100, 'currency' => 'USD', 'reference' => 'PAY-AP-1',
    ]);

    app(ApplyPayment::class)->handle($payment, $item, 100);

    expect($item->fresh()->status)->toBe(PayableStatus::Partial)
        ->and($payment->fresh()->status)->toBe(PayableStatus::Applied)
        ->and((float) DB::table('accounting_ap_accounts')->where('party_id', $party->id)->value('current_balance'))->toBe(150.0)
        ->and(app(AgingQuery::class)->handle($party->id, new DateTimeImmutable('2026-08-15')))->toBe(['current' => 0.0, '1_30' => 150.0, '31_60' => 0.0, '61_90' => 0.0, 'over_90' => 0.0]);
});

function payableParty(): Party
{
    $legalEntityId = DB::table('accounting_legal_entities')->insertGetId([
        'name' => 'AP Entity', 'currency_code' => 'USD', 'created_at' => now(), 'updated_at' => now(),
    ]);

    return Party::create(['legal_entity_id' => $legalEntityId, 'type' => PartyType::Supplier, 'name' => 'AP Supplier']);
}
