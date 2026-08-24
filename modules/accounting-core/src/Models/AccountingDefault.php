<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingDefault extends Model
{
    protected $table = 'accounting_defaults';

    protected $fillable = ['book_id', 'key', 'value'];

    protected $casts = ['value' => 'array'];
}
