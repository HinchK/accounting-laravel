<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Events;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
final class JournalPosted implements ShouldDispatchAfterCommit { public function __construct(public readonly JournalEntry $journal,public readonly ?string $actor=null) {} }
