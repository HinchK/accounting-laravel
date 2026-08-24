<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Events;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
final class JournalPosted { public function __construct(public readonly JournalEntry $journal,public readonly ?string $actor=null) {} }
