<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivable\Queries;

use Liberu\Accounting\AccountsReceivable\Models\ReceivableOpenItem;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableReceipt;

final class CustomerSubledgerQuery
{
    public function handle(int $partyId): array
    {
        return ['open_items' => ReceivableOpenItem::with('disputes')->where('party_id', $partyId)->orderBy('due_on')->get(), 'receipts' => ReceivableReceipt::with('applications')->where('party_id', $partyId)->orderByDesc('received_on')->get(), 'balance' => (float) ReceivableOpenItem::where('party_id', $partyId)->get()->sum(fn (ReceivableOpenItem $item) => $item->outstanding())];
    }
}
