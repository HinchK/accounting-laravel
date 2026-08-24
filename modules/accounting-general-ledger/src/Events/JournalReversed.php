<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Events;
use Liberu\Accounting\GeneralLedger\Models\{JournalEntry,JournalLine};
final class JournalReversed { public function __construct(public readonly JournalEntry $journal,public readonly JournalEntry $reversal,public readonly ?string $actor=null) {} }
