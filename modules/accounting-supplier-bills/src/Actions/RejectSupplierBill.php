<?php

declare(strict_types=1);

namespace Liberu\Accounting\SupplierBills\Actions;

use Liberu\Accounting\SupplierBills\Enums\SupplierBillStatus;
use Liberu\Accounting\SupplierBills\Exceptions\InvalidSupplierBill;
use Liberu\Accounting\SupplierBills\Models\SupplierBill;

final class RejectSupplierBill
{
    public function handle(SupplierBill $bill, string $reason): SupplierBill
    {
        if (blank($reason) || ! in_array($bill->status, [SupplierBillStatus::Draft, SupplierBillStatus::Approved], true)) {
            throw new InvalidSupplierBill('Only draft or approved bills may be rejected and a reason is required.');
        }
        $bill->update(['status' => SupplierBillStatus::Rejected, 'approval_status' => 'rejected', 'rejection_reason' => $reason]);

        return $bill->refresh();
    }
}
