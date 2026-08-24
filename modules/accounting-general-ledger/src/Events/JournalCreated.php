<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Events;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
final class JournalCreated { public function __construct(public readonly JournalEntry $journal) {} }
