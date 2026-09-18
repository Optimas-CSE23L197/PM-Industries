<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Services\Crm\{CustomerService,SalesService};
use Illuminate\Http\Request;
use App\Services\Crm\ReceiptFollowupService;

class ReceiptFollowupCntlr extends Controller
{
    public function receiptFollowup(ReceiptFollowupService $rfs)
    {
        $followups = $rfs->getReceiptFollowupList(0, 'Y');
        $followups = $followups['data']['data'] ?? [];
        // dd($followups);
        return view('crm.transactions.receipt_followup.index', compact('followups'));
    }

    public function receiptFollowupDetails(
        ReceiptFollowupService $rfs,
        CustomerService $cs,
        SalesService $ss,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $billintno           = $request->input('billintno');
        $parentFollowupIntno = $request->input('parent_followup_intno');

        $followup       = [];
        $parentFollowup = [];

        // Case 1: Edit / View existing followup
        if ($intno) {
            $response = $rfs->getReceiptFollowupList($intno, 'Y');
            $followup = $response['data']['data'][0] ?? [];
        }
        // Case 2: Followup of Followup (vwedt = 4)
        elseif ($vwedt == 4 && $parentFollowupIntno) {
            $parentResp     = $rfs->getReceiptFollowupList($parentFollowupIntno, 'Y');
            $parentFollowup = $parentResp['data']['data'][0] ?? [];

            $followup['billintno']         = $parentFollowup['billintno'] ?? $billintno;
            $followup['followup_date']     = date('Y-m-d');
            $followup['next_followup_date']= $parentFollowup['next_followup_date'] ?? '';
            $followup['status']            = 'PENDING';
        }
        // Case 3: From Receipt (vwedt = 3)
        elseif ($vwedt == 3 && $billintno) {
            $followup['billintno']     = $billintno;
            $followup['followup_date'] = date('Y-m-d');
        }

        // Dropdowns
        $customersResp = $cs->getCustomerList(0, session('compCdC') ?? 1, 'Y');
        $customers     = $customersResp['data']['data'] ?? $customersResp['data'] ?? [];

        // Fetch sales invoices (SALE transactions)
        $salesResp = $ss->getSalesList(0, 'Y');
        $invoices  = $salesResp['data']['data'] ?? [];

        return view('crm.transactions.receipt_followup.form', compact(
            'followup', 'vwedt', 'customers', 'invoices', 'parentFollowup'
        ));
    }

    public function saveReceiptFollowup(Request $request, ReceiptFollowupService $rfs)
    {
        $intno = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        $data = [
            'billintno'          => $request->input('billintno'),
            'followup_date'      => $request->input('followup_date'),
            'next_followup_date' => $request->input('next_followup_date'),
            'remarks'            => $request->input('remarks'),
            'status'             => $request->input('status', 'PENDING'),
            'usercd'             => $usercd
        ];

        $resp = $rfs->putReceiptFollowup($intno, $data);
        return response()->json($resp);
    }

    public function statReceiptFollowup(ReceiptFollowupService $rfs, $intno, $actyn)
    {
        $res = $rfs->receiptFollowupStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('receiptFollowup')->with('success', $res['data']['message']);
        else
            return redirect()->Route('receiptFollowup')->with('error', $res['data']['message']);
    }

    public function printReceiptFollowupList(ReceiptFollowupService $rfs)
    {
        $followups = $rfs->getReceiptFollowupList(0, 'Y');
        $followups = $followups['data']['data'] ?? [];
        return view('crm.transactions.receipt_followup.print', compact('followups'));
    }
}