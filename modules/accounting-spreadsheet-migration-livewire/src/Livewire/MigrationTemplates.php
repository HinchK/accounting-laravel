<?php
declare(strict_types=1);
namespace Liberu\Accounting\SpreadsheetMigrationLivewire\Livewire;
use Livewire\Component;use Liberu\Accounting\SpreadsheetMigration\Models\MigrationTemplate;
final class MigrationTemplates extends Component {public function render():mixed{abort_unless(auth()->check(),403);return view('module-accounting-spreadsheet-migration::templates',['templates'=>MigrationTemplate::query()->latest()->paginate(25)]);}}
