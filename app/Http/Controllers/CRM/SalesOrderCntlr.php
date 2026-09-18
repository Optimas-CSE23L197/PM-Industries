<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\SalesOrderService;
use App\Services\Crm\QuotationService;
use App\Services\Production\FinishedItemService;

class SalesOrderCntlr extends Controller
{
    public function salesOrder(SalesOrderService $sos)
    {
        $response    = $sos->getSalesOrderList(0, 'Y');
        $salesOrders = $response['data']['data'] ?? $response['data'] ?? [];

        return view('crm.transactions.sales_order.index', compact('salesOrders'));
    }

    public function salesOrderDetails(
        SalesOrderService $sos,
        QuotationService $qs,
        FinishedItemService $fis,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $quotationIntno = $request->input('quotationintno');
        $salesOrder     = [];

        // View / Edit existing
        if ($intno) {
            $response   = $sos->getSalesOrderList($intno, 'Y');
            $salesOrder = $response['data']['data'][0] ?? $response['data'][0] ?? [];
        }
        // From Quotation (vwedt = 3)
        elseif ($vwedt == 3 && $quotationIntno) {
            $qResp = $qs->getQuotationList($quotationIntno, 'Y');
            $qData = $qResp['data']['data'][0] ?? $qResp['data'][0] ?? [];

            $salesOrder['quotationintno'] = $quotationIntno;
            $salesOrder['customercd']     = $qData['customercd'] ?? '';
            $salesOrder['customer_name']  = $qData['customer_name'] ?? '';
            $salesOrder['order_date']     = date('Y-m-d');
            $salesOrder['items']          = $qData['items'] ?? [];
        }

        // Dropdowns
        $qResp      = $qs->getQuotationList(0, 'Y');
        $quotations = $qResp['data']['data'] ?? $qResp['data'] ?? [];

        $fiResp = $fis->getFinishedItemList(0, session('compCdC') ?? 1, 'Y');
        $items  = $fiResp['data']['data'] ?? $fiResp['data'] ?? [];

        // Customers (for autocomplete or fallback)
        $customers = []; // yahan apna CustomerService use kar agar chahiye

        return view('crm.transactions.sales_order.form', compact(
            'salesOrder', 'vwedt', 'quotations', 'items', 'customers'
        ));
    }

    public function saveSalesOrder(Request $request, SalesOrderService $sos)
    {
        $intno  = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        $itemsArr = [];
        foreach ($request->input('items', []) as $row) {
            if (empty($row['finisheditemcd']) || empty($row['qty'])) continue;

            $itemsArr[] = [
                'finisheditemcd' => (int) $row['finisheditemcd'],
                'description'    => $row['description'] ?? '',
                'qty'            => (float) $row['qty'],
                'rate'           => (float) ($row['rate'] ?? 0),
                'delivered_qty'  => (float) ($row['delivered_qty'] ?? 0),
                'usercd'         => $usercd
            ];
        }

        if (empty($itemsArr)) {
            return response()->json(['error' => true, 'message' => 'Please add at least one item.']);
        }

        $data = [
            'compcd'         => session('compCdC') ?? 1,
            'order_date'     => $request->input('order_date'),
            'customercd'     => $request->input('customercd'),
            'quotationintno' => $request->input('quotationintno'),
            'status'         => $request->input('status', 'OPEN'),
            'delivery_date'  => $request->input('delivery_date'),
            'usercd'         => $usercd,
            'items'          => json_encode($itemsArr)
        ];

        $resp = $sos->putSalesOrder($intno, $data);
        return response()->json($resp);
    }

    public function statSalesOrder(SalesOrderService $sos, $intno, $actyn)
    {
        $res = $sos->salesOrderStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('salesOrder')->with('success', $res['data']['message']);
        else
            return redirect()->Route('salesOrder')->with('error', $res['data']['message']);
    }

    public function printSalesOrderList(SalesOrderService $sos)
    {
        $response    = $sos->getSalesOrderList(0, 'Y');
        $salesOrders = $response['data']['data'] ?? [];

        return view('crm.transactions.sales_order.print', compact('salesOrders'));
    }
}