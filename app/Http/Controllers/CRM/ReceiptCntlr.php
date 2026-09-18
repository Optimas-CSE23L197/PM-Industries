<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\ReceiptService;

class ReceiptCntlr extends Controller
{
    public function receipt(ReceiptService $rs)
    {
        $receipts = $rs->getReceiptList(0, 'Y');
        $receipts = $receipts['data'] ?? [];
        return view('crm.transactions.receipt.index', compact('receipts'));
    }

    public function receiptDetails(ReceiptService $rs, $vwedt = null, $intno = null)
    {
        $receipt = [];
        if ($intno) {
            $receipt = $rs->getReceiptSingle($intno, 'N');
            $receipt = $receipt['data'][0] ?? [];
        }
        return view('crm.transactions.receipt.form', compact('receipt', 'vwedt'));
    }

    public function saveReceipt(Request $request, ReceiptService $rs)
    {
        $intno = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        $itemsArr = [];
        foreach ($request->input('items', []) as $row) {
            if (empty($row['billintno']) || empty($row['rcptamt'])) continue;
            $itemsArr[] = [
                'billintno' => (int) $row['billintno'],
                'tdsamt'    => (float) ($row['tdsamt'] ?? 0),
                'tdsactcd'  => (int) ($row['tdsactcd'] ?? 0),
                'billadj'   => (float) ($row['billadj'] ?? 0),
                'rcptamt'   => (float) $row['rcptamt']
            ];
        }

        if (empty($itemsArr)) {
            return response()->json(['error' => true, 'message' => 'Please add at least one item.']);
        }

        $data = [
            'rcptdt'                => $request->input('rcptdt'),
            'type_sale_purc_contractor' => $request->input('type_sale_purc_contractor', 'S'),
            'rp'                    => $request->input('rp', 'R'),
            'bankcd'                => $request->input('bankcd'),
            'quotintno'             => $request->input('quotintno'),
            'invintno'              => $request->input('invintno'),
            'partycd'               => $request->input('partycd'),
            'billintno'             => $request->input('billintno'),
            'modeofpay'             => $request->input('modeofpay'),
            'rcptdescr'             => $request->input('rcptdescr'),
            'paytranno'             => $request->input('paytranno'),
            'paytrandt'             => $request->input('paytrandt'),
            'usercd'                => $usercd,
            'items'                 => json_encode($itemsArr)
        ];

        $resp = $rs->putReceipt(session('compCdC') ?? 1, $intno, $data);
        return response()->json($resp);
    }

    public function statReceipt(ReceiptService $rs, $intno, $actyn)
    {
        $res = $rs->receiptStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('receipt')->with('success', $res['message']);
        else
            return redirect()->Route('receipt')->with('error', $res['message']);
    }

    public function printReceiptList(ReceiptService $rs)
    {
        $receipts = $rs->getReceiptList(0, 'Y');
        $receipts = $receipts['data'] ?? [];
        return view('crm.transactions.receipt.print', compact('receipts'));
    }
}