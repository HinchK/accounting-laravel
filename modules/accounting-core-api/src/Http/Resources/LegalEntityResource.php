<?php

declare(strict_types=1);

namespace Liberu\Accounting\CoreApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Liberu\Accounting\Core\Models\LegalEntity;

/** @mixin LegalEntity */
final class LegalEntityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->resource->getKey(),
            'type' => 'accounting-legal-entity',
            'attributes' => [
                'name' => $this->resource->name,
                'registration_number' => $this->resource->registration_number,
                'currency_code' => $this->resource->currency_code,
                'accounting_basis' => $this->resource->accounting_basis,
                'is_active' => $this->resource->is_active,
                'created_at' => $this->resource->created_at?->toISOString(),
                'updated_at' => $this->resource->updated_at?->toISOString(),
            ],
        ];
    }
}
