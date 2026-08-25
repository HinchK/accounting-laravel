<?php

declare(strict_types=1);

namespace Liberu\Accounting\SalesOrdersApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liberu\Accounting\SalesOrders\Actions\AddSalesOrderDeposit;
use Liberu\Accounting\SalesOrders\Actions\CreateSalesOrder;
use Liberu\Accounting\SalesOrders\Actions\RecordPartialInvoice;
use Liberu\Accounting\SalesOrders\Actions\TransitionSalesOrder;
use Liberu\Accounting\SalesOrders\Models\SalesOrder;
use Liberu\Accounting\SalesOrders\Queries\SalesOrderQuery;
use Liberu\Accounting\SalesOrdersApi\Http\Resources\SalesOrderResource;

final class SalesOrderController extends Controller
{
    public function index(Request $request, SalesOrderQuery $query): mixed
    {
        return SalesOrderResource::collection($query->paginate($request->string('customer_id')->value() ?: null, $request->string('status')->value() ?: null, $request->integer('per_page', 25)));
    }

    public function show(SalesOrder $salesOrder): SalesOrderResource
    {
        return new SalesOrderResource($salesOrder->load('items', 'deposits', 'allocations'));
    }

    public function store(Request $request, CreateSalesOrder $action): SalesOrderResource
    {
        $data = $request->validate(['customer_id' => 'required|string|max:160', 'estimate_id' => 'nullable|string|max:160', 'currency' => 'required|string|size:3', 'order_date' => 'required|date', 'notes' => 'nullable|string', 'items' => 'required|array|min:1', 'items.*.description' => 'required|string', 'items.*.quantity' => 'required|numeric|min:0.0001', 'items.*.unit_price' => 'required|numeric|min:0', 'items.*.tax_rate' => 'nullable|numeric|min:0|max:100']);
        $items = $data['items'];
        unset($data['items']);

        return new SalesOrderResource($action->handle($data, $items));
    }

    public function transition(Request $request, SalesOrder $salesOrder, TransitionSalesOrder $action): SalesOrderResource
    {
        return new SalesOrderResource($action->handle($salesOrder, $request->validate(['status' => 'required|string'])['status']));
    }

    public function deposit(Request $request, SalesOrder $salesOrder, AddSalesOrderDeposit $action): SalesOrderResource
    {
        $data = $request->validate(['reference' => 'required|string|max:100', 'amount' => 'required|numeric|min:0.01', 'currency' => 'required|string|size:3']);
        $action->handle($salesOrder, $data);

        return new SalesOrderResource($salesOrder->refresh());
    }

    public function invoice(Request $request, SalesOrder $salesOrder, RecordPartialInvoice $action): SalesOrderResource
    {
        $data = $request->validate(['amount' => 'required|numeric|min:0.01', 'invoice_reference' => 'required|string|max:160']);

        return new SalesOrderResource($action->handle($salesOrder, $data['amount'], $data['invoice_reference']));
    }
}
