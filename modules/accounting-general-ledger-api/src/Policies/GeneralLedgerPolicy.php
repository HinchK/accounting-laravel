<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedgerApi\Policies;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
class GeneralLedgerPolicy { public function viewAny($user): bool{return (bool)$user;} public function view($user,JournalEntry $entry): bool{return (bool)$user;} public function create($user): bool{return (bool)$user;} public function update($user,JournalEntry $entry): bool{return (bool)$user;} public function delete($user,JournalEntry $entry): bool{return (bool)$user;} }
