<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivableApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceivableOpenItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id' => (string) $this->id, 'type' => 'accounting-ar-open-item', 'attributes' => ['party_id' => $this->party_id, 'reference' => $this->reference, 'issued_on' => $this->issued_on?->toIso8601String(), 'due_on' => $this->due_on?->toIso8601String(), 'original_amount' => (string) $this->original_amount, 'applied_amount' => (string) $this->applied_amount, 'outstanding' => (string) number_format($this->outstanding(), 2, '.', ''), 'currency' => $this->currency, 'status' => $this->status->value, 'metadata' => $this->metadata]];
    }
}
