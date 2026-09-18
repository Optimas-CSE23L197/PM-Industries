<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Services\Crm\{QuotationService,SalesService};
use App\Services\RawMaterialsInventory\RawItemService;
use Illuminate\Http\Request;


class SalesCntlr extends Controller
{
    /**
     * Sales List (Index)
     */
    public function sales(SalesService $ss)
    {
        $response = $ss->getSalesList(0, 'Y');
        $sales    = $response['data']['data'] ?? [];

        return view('crm.transactions.sales.index', compact('sales'));
    }

    public function salesDetails(
        SalesService $ss,
        QuotationService $qs,
        RawItemService $ris,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $salesOrderIntno = $request->input('salesorderintno');
        $quotationIntno  = $request->input('qutintno');

        $sales = [];

        // View / Edit existing
        if ($intno) {
            $response = $ss->getSalesList($intno, 'Y');
            $sales    = $response['data']['data'][0] ?? $response['data'][0] ?? [];
        }
        // From Sales Order (vwedt = 3)
        elseif ($vwedt == 3 && $salesOrderIntno) {
            $sales['salesorderintno'] = $salesOrderIntno;
            $sales['trandt']          = date('Y-m-d');
        }
        // From Quotation
        elseif ($quotationIntno) {
            $sales['qutintno'] = $quotationIntno;
            $sales['trandt']   = date('Y-m-d');
        }

        // Dropdowns
        $qResp      = $qs->getQuotationList(0, 'Y');
        $quotations = $qResp['data']['data'] ?? $qResp['data'] ?? [];

        $itemsResp = $ris->getList(0, 'Y');
        $items     = $itemsResp['data']['data'] ?? $itemsResp['data'] ?? [];

        return view('crm.transactions.sales.form', compact(
            'sales', 'vwedt', 'quotations', 'items'
        ));
    }

    /**
     * Save (Add / Edit)
     */
    public function saveSales(Request $request, SalesService $ss)
    {
        $intno  = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        // Build items JSON
        $itemsArr = [];
        foreach ($request->input('items', []) as $row) {
            if (empty($row['itemcd']) || empty($row['qty'])) continue;

            $itemsArr[] = [
                'itemcd'    => (int) $row['itemcd'],
                'serialno'  => $row['serialno'] ?? '',
                'itemdescr' => $row['itemdescr'] ?? '',
                'qty'       => (float) $row['qty'],
                'rate'      => (float) ($row['rate'] ?? 0),
                'discper'   => (float) ($row['discper'] ?? 0),
                'discamt'   => (float) ($row['discamt'] ?? 0),
                'sgstper'   => (float) ($row['sgstper'] ?? 0),
                'sgstamt'   => (float) ($row['sgstamt'] ?? 0),
                'cgstper'   => (float) ($row['cgstper'] ?? 0),
                'cgstamt'   => (float) ($row['cgstamt'] ?? 0),
                'igstper'   => (float) ($row['igstper'] ?? 0),
                'igstamt'   => (float) ($row['igstamt'] ?? 0),
                'amount'    => (float) ($row['amount'] ?? 0)
            ];
        }

        if (empty($itemsArr)) {
            return response()->json([
                'error'   => true,
                'message' => 'Please add at least one item.'
            ]);
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
            'termncondition'=> $request->input('termncondition', ''),
            'duedt'         => $request->input('duedt'),
            'clearedyn'     => $request->input('clearedyn', 'N'),
            'paidamt'       => (float) $request->input('paidamt', 0),
            'items'         => json_encode($itemsArr)
        ];

        $resp = $ss->putSales($intno, $data);
        return response()->json($resp);
    }

    /**
     * Status change
     */
    public function statSales(SalesService $ss, $intno, $actyn)
    {
        $res = $ss->salesStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('sales')->with('success', $res['data']['message']);
        else
            return redirect()->Route('sales')->with('error', $res['data']['message']);
    }

    /**
     * Print
     */
    public function printSalesList(SalesService $ss)
    {
        $response = $ss->getSalesList(0, 'Y');
        $sales    = $response['data']['data'] ?? [];

        return view('crm.transactions.sales.print', compact('sales'));
    }
}