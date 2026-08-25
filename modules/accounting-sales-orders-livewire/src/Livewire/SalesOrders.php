<?php
declare(strict_types=1);
namespace Liberu\Accounting\SalesOrdersLivewire\Livewire;
use Livewire\Component;use Livewire\WithPagination;use Liberu\Accounting\SalesOrders\Queries\SalesOrderQuery;
final class SalesOrders extends Component {use WithPagination;public string $status='';public function render():mixed{abort_unless(auth()->check(),403);return view('module-accounting-sales-orders::orders',['orders'=>app(SalesOrderQuery::class)->paginate(null,$this->status?:null)]);}}
