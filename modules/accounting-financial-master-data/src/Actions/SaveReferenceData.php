<?php

declare(strict_types=1);

namespace Liberu\Accounting\FinancialMasterData\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\FinancialMasterData\Events\MasterRecordCreated;

final class SaveReferenceData
{
    public function __construct(private readonly Dispatcher $events) {}

    /** @param class-string<Model> $modelClass @param array<string, mixed> $attributes */
    public function handle(string $modelClass, array $attributes, ?Model $record = null): Model
    {
        return DB::transaction(function () use ($modelClass, $attributes, $record): Model {
            $record ??= new $modelClass();
            $created = ! $record->exists;
            $record->fill($attributes);
            $record->save();
            if ($created) {
                $this->events->dispatch(new MasterRecordCreated($record));
            }
            return $record->refresh();
        });
    }
}
