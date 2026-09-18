<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\SalesReturnService;
use App\Services\Crm\SalesService;

class SalesReturnCntlr extends Controller
{
    public function salesReturn(SalesReturnService $srs)
    {
        $salesReturns = $srs->getSalesReturnList(0, 'Y');
        $salesReturns = $salesReturns['data']['data'] ?? [];

        return view('crm.transactions.sales_return.index', compact('salesReturns'));
    }

    public function salesReturnDetails(
        SalesReturnService $srs,
        SalesService $ss,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $saleintno = $request->input('saleintno');

        $salesReturn = [];

        // View/Edit existing
        if ($intno) {
            $response    = $srs->getSalesReturnList($intno, 'Y');
            $salesReturn = $response['data']['data'][0] ?? [];
        }
        // From Sale (vwedt = 3)
        elseif ($vwedt == 3 && $saleintno) {
            $saleResp    = $ss->getSalesList($saleintno, 'Y');
            $saleData    = $saleResp['data']['data'][0] ?? [];

            $salesReturn = [
                'saleintno'     => $saleintno,
                'partycd'       => $saleData['partycd'] ?? '',
                'customer_name' => $saleData['customer_name'] ?? $saleData['party_name'] ?? '',
                'trandt'        => date('Y-m-d'),
                'qutintno'      => $saleData['qutintno'] ?? 0,
                'quotation_no'  => $saleData['quotation_no'] ?? '',
                'items'         => $saleData['items'] ?? [],
                'basic'         => $saleData['basic'] ?? 0,
                'discper'       => $saleData['discper'] ?? 0,
                'discamt'       => $saleData['discamt'] ?? 0,
                'cgstper'       => $saleData['cgstper'] ?? 0,
                'cgstamt'       => $saleData['cgstamt'] ?? 0,
                'sgstper'       => $saleData['sgstper'] ?? 0,
                'sgstamt'       => $saleData['sgstamt'] ?? 0,
                'igstper'       => $saleData['igstper'] ?? 0,
                'igstamt'       => $saleData['igstamt'] ?? 0,
            ];
        }

        // List of Sales for dropdown
        $salesResp = $ss->getSalesList(0, 'Y');
        $sales     = $salesResp['data']['data'] ?? [];

        return view('crm.transactions.sales_return.form', compact(
            'salesReturn', 'vwedt', 'sales'
        ));
    }

    public function saveSalesReturn(Request $request, SalesReturnService $srs)
    {
        $intno  = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        // Build items JSON
        $itemsArr = [];
        foreach ($request->input('items', []) as $row) {
            if (empty($row['itemcd']) || empty($row['qty'])) continue;

            $itemsArr[] = [
                'itemcd'      => (int) $row['itemcd'],
                'serialno'    => $row['serialno'] ?? '',
                'itemdescr'   => $row['itemdescr'] ?? '',
                'qty'         => (float) $row['qty'],
                'rate'        => (float) ($row['rate'] ?? 0),
                'discper'     => (float) ($row['discper'] ?? 0),
                'discamt'     => (float) ($row['discamt'] ?? 0),
                'sgstper'     => (float) ($row['sgstper'] ?? 0),
                'sgstamt'     => (float) ($row['sgstamt'] ?? 0),
                'cgstper'     => (float) ($row['cgstper'] ?? 0),
                'cgstamt'     => (float) ($row['cgstamt'] ?? 0),
                'igstper'     => (float) ($row['igstper'] ?? 0),
                'igstamt'     => (float) ($row['igstamt'] ?? 0),
                'amount'      => (float) ($row['amount'] ?? 0)
            ];
        }

        if (empty($itemsArr)) {
            return response()->json(['error' => true, 'message' => 'Please add at least one item.']);
        }

        $data = [
            'compcd'        => session('compCdC') ?? 1,
            'billtypecd'    => $request->input('billtypecd', 1),
            'trandt'        => $request->input('trandt'),
            'partycd'       => $request->input('partycd'),
            'partybillno'   => $request->input('partybillno'),
            'partybilldt'   => $request->input('partybilldt'),
            'qutintno'      => $request->input('qutintno', 0),
            'narration'     => $request->input('narration'),
            'fromdt'        => $request->input('fromdt'),
            'todt'          => $request->input('todt'),
            'localconvamt'  => (float) $request->input('localconvamt', 0),
            'otheramt'      => (float) $request->input('otheramt', 0),
            'basic'         => (float) $request->input('basic', 0),
            'discper'       => (float) $request->input('discper', 0),
            'discamt'       => (float) $request->input('discamt', 0),
            'dr'            => (float) $request->input('dr', 0),
            'cr'            => (float) $request->input('cr', 0),
            'cgstper'       => (float) $request->input('cgstper', 0),
            'cgstamt'       => (float) $request->input('cgstamt', 0),
            'sgstper'       => (float) $request->input('sgstper', 0),
            'sgstamt'       => (float) $request->input('sgstamt', 0),
            'igstper'       => (float) $request->input('igstper', 0),
            'igstamt'       => (float) $request->input('igstamt', 0),
            'othersper'     => (float) $request->input('othersper', 0),
            'othersamt'     => (float) $request->input('othersamt', 0),
            'rndoff'        => (float) $request->input('rndoff', 0),
            'modeofpay'     => $request->input('modeofpay', 'C'),
            'bankcd'        => $request->input('bankcd', 0),
            'paytranno'     => $request->input('paytranno', ''),
            'paytrandt'     => $request->input('paytrandt'),
            'paytranremark' => $request->input('paytranremark', ''),
            'usercd'        => $usercd,
            'invstatus'     => $request->input('invstatus', ''),
            'delnoteno'     => $request->input('delnoteno', ''),
            'purcordintno'  => $request->input('purcordintno', 0),
            'refno'         => $request->input('refno', ''),
            'refnodt'       => $request->input('refnodt'),
            'othref'        => $request->input('othref', ''),
            'orderno'       => $request->input('orderno', ''),
            'orderdt'       => $request->input('orderdt'),
            'termncondition' => $request->input('termncondition', ''),
            'duedt'         => $request->input('duedt'),
            'clearedyn'     => $request->input('clearedyn', 'N'),
            'paidamt'       => (float) $request->input('paidamt', 0),
            'items'         => json_encode($itemsArr)
        ];

        $resp = $srs->putSalesReturn($intno, $data);
        return response()->json($resp);
    }

    public function statSalesReturn(SalesReturnService $srs, $intno, $actyn)
    {
        $res = $srs->salesReturnStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('salesReturn')->with('success', $res['data']['message']);
        else
            return redirect()->Route('salesReturn')->with('error', $res['data']['message']);
    }

    public function printSalesReturnList(SalesReturnService $srs)
    {
        $salesReturns = $srs->getSalesReturnList(0, 'Y');
        $salesReturns = $salesReturns['data']['data'] ?? [];
        return view('crm.transactions.sales_return.print', compact('salesReturns'));
    }
}