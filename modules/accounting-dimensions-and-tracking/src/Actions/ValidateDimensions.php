<?php
declare(strict_types=1);
namespace Liberu\Accounting\Dimensions\Actions;
use Liberu\Accounting\Dimensions\Exceptions\InvalidDimension; use Liberu\Accounting\Dimensions\Models\Dimension;
final class ValidateDimensions { public function handle(array $values):array { $dimensions=Dimension::with('values')->where('is_active',true)->get()->keyBy(fn($d)=>$d->kind->value);foreach($dimensions as $kind=>$dimension){if($dimension->is_required&&!array_key_exists($kind,$values))throw new InvalidDimension("The {$kind} dimension is required.");if(array_key_exists($kind,$values)){foreach((array)$values[$kind] as $code){if(!$dimension->values->first(fn($value)=>$value->code===$code&&$value->is_active))throw new InvalidDimension("Unknown or inactive {$kind} dimension value: {$code}.");}}}return $values; } }
