<?php
declare(strict_types=1);
namespace Liberu\Accounting\Core\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Database\Eloquent\Model;
final readonly class AccountingSettingSaved { use Dispatchable; public function __construct(public Model $setting) {} }
