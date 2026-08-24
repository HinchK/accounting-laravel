<?php
declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Liberu\Accounting\ChartOfAccounts\Models\Account;
use Liberu\Accounting\Core\Models\{Book,LegalEntity};
use Liberu\Accounting\GeneralLedger\Actions\{CreateJournal,GenerateRecurringJournal,PostJournal,ReverseJournal,SaveRecurringJournal};
use Liberu\Accounting\GeneralLedger\Enums\JournalStatus;
use Liberu\Accounting\GeneralLedger\Exceptions\InvalidJournal;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
use Tests\TestCase;

class AccountingGeneralLedgerTest extends TestCase
{
    use RefreshDatabase;

    private function book(): Book
    {
        $entity = LegalEntity::create(['name' => 'Ledger Entity', 'currency_code' => 'USD']);
        return Book::create(['legal_entity_id' => $entity->id, 'name' => 'Main Book', 'code' => 'MAIN', 'accounting_basis' => 'accrual']);
    }

    private function lines(Book $book): array
    {
        $cash = Account::create(['legal_entity_id' => $book->legal_entity_id, 'code' => '1000', 'name' => 'Cash', 'type' => 'asset', 'normal_balance' => 'debit']);
        $revenue = Account::create(['legal_entity_id' => $book->legal_entity_id, 'code' => '4000', 'name' => 'Revenue', 'type' => 'revenue', 'normal_balance' => 'credit']);
        return [['account_id' => $cash->id, 'debit' => 100, 'credit' => 0], ['account_id' => $revenue->id, 'debit' => 0, 'credit' => 100]];
    }

    public function test_posted_journals_are_immutable_and_reversible(): void
    {
        $book = $this->book();
        $journal = app(CreateJournal::class)->handle(['book_id' => $book->id, 'entry_date' => '2026-08-24'], $this->lines($book));
        $posted = app(PostJournal::class)->handle($journal, 'actor-1');

        $this->assertSame(JournalStatus::Posted, $posted->status);
        $this->expectException(\LogicException::class);
        $posted->update(['description' => 'forbidden edit']);
    }

    public function test_reversal_creates_a_posted_opposite_entry(): void
    {
        $book = $this->book();
        $journal = app(CreateJournal::class)->handle(['book_id' => $book->id, 'entry_date' => '2026-08-24'], $this->lines($book));
        $posted = app(PostJournal::class)->handle($journal);
        $reversal = app(ReverseJournal::class)->handle($posted);

        $this->assertSame(JournalStatus::Reversed, $posted->fresh()->status);
        $this->assertSame(JournalStatus::Posted, $reversal->status);
        $this->assertSame($posted->id, $reversal->reversal_of_id);
    }

    public function test_recurring_journal_generates_once_and_advances_schedule(): void
    {
        $book = $this->book();
        $template = app(SaveRecurringJournal::class)->handle(['book_id' => $book->id, 'name' => 'Monthly close', 'frequency' => 'monthly', 'next_run_on' => '2026-08-24', 'lines' => $this->lines($book)]);
        $journal = app(GenerateRecurringJournal::class)->handle($template);

        $this->assertSame('recurring', $journal->journal_type->value);
        $this->assertSame('2026-09-24', $template->fresh()->next_run_on->toDateString());
    }
}
