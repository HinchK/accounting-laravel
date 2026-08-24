<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'accounting_books';

    protected $fillable = ['legal_entity_id', 'name', 'code', 'accounting_basis', 'is_active'];

    protected $casts = ['is_active' => 'bool'];
}
