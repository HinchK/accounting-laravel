<?php
declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Liberu\Accounting\ChartOfAccounts\Models\Account;
use Liberu\Accounting\Core\Models\{Book,LegalEntity};
use Liberu\Accounting\FinancialStatements\Queries\StatementQuery;
use Liberu\Accounting\GeneralLedger\Actions\{CreateJournal,PostJournal};
use Tests\TestCase;

class AccountingFinancialStatementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_statements_calculate_posted_ledger_data_and_drill_through(): void
    {
        $entity = LegalEntity::create(['name' => 'Statements Entity', 'currency_code' => 'USD']);
        $book = Book::create(['legal_entity_id' => $entity->id, 'name' => 'Statements Book', 'code' => 'STAT', 'accounting_basis' => 'accrual']);
        $cash = Account::create(['legal_entity_id' => $entity->id, 'code' => '1000', 'name' => 'Cash', 'type' => 'asset', 'normal_balance' => 'debit']);
        $revenue = Account::create(['legal_entity_id' => $entity->id, 'code' => '4000', 'name' => 'Revenue', 'type' => 'revenue', 'normal_balance' => 'credit']);
        $expense = Account::create(['legal_entity_id' => $entity->id, 'code' => '5000', 'name' => 'Expense', 'type' => 'expense', 'normal_balance' => 'debit']);

        app(PostJournal::class)->handle(app(CreateJournal::class)->handle(['book_id' => $book->id, 'entry_date' => '2026-01-15'], [
            ['account_id' => $cash->id, 'debit' => 250, 'credit' => 0], ['account_id' => $revenue->id, 'debit' => 0, 'credit' => 250],
        ]));
        app(PostJournal::class)->handle(app(CreateJournal::class)->handle(['book_id' => $book->id, 'entry_date' => '2026-01-20'], [
            ['account_id' => $expense->id, 'debit' => 100, 'credit' => 0], ['account_id' => $cash->id, 'debit' => 0, 'credit' => 100],
        ]));

        $query = app(StatementQuery::class);
        $pl = $query->profitAndLoss($book->id, '2026-01-01', '2026-01-31');
        $sheet = $query->balanceSheet($book->id, '2026-01-31');
        $comparative = $query->comparative($book->id, '2026-01-01', '2026-01-31', '2025-01-01', '2025-01-31');
        $drillThrough = $query->drillThrough($book->id, $cash->id, '2026-01-01', '2026-01-31');

        $this->assertSame(150.0, $pl['net_income']);
        $this->assertSame(150.0, $sheet['assets']['total']);
        $this->assertSame(150.0, $sheet['total_liabilities_and_equity']);
        $this->assertSame(0.0, $comparative['comparative']['net_income']);
        $this->assertCount(2, $drillThrough);
    }
}
