<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\QuotationFollowupService;
use App\Services\Crm\QuotationService;

class QuotationFollowupCntlr extends Controller
{
    public function quotationFollowup(QuotationFollowupService $qfs)
    {
        $response  = $qfs->getQuotationFollowupList(0, 'Y');
        $followups = $response['data']['data'] ?? $response['data'] ?? [];

        return view('crm.transactions.quotation_followup.index', compact('followups'));
    }

    public function quotationFollowupDetails(
        QuotationFollowupService $qfs,
        QuotationService $qs,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $quotationintno      = $request->input('quotationintno');
        $parentFollowupIntno = $request->input('parent_followup_intno');

        $followup       = [];
        $parentFollowup = [];

        // Case 1: Edit/View existing
        if ($intno) {
            $response = $qfs->getQuotationFollowupSingle($intno, 'Y');
            $followup = $response['data']['data'][0] ?? $response['data'][0] ?? [];
        }
        // Case 2: Followup of Followup (vwedt = 4)
        elseif ($vwedt == 4 && $parentFollowupIntno) {
            $parentResp     = $qfs->getQuotationFollowupSingle($parentFollowupIntno, 'Y');
            $parentFollowup = $parentResp['data']['data'][0] ?? $parentResp['data'][0] ?? [];

            $followup['quotationintno']     = $parentFollowup['quotationintno'] ?? $quotationintno;
            $followup['followup_date']      = date('Y-m-d');
            $followup['next_followup_date'] = $parentFollowup['next_followup_date'] ?? '';
            $followup['status']             = 'OPEN';
        }
        // Case 3: From Quotation (vwedt = 3)
        elseif ($vwedt == 3 && $quotationintno) {
            $followup['quotationintno'] = $quotationintno;
            $followup['followup_date']  = date('Y-m-d');
        }

        // Dropdowns
        $qResp      = $qs->getQuotationList(0, 'Y');
        $quotations = $qResp['data']['data'] ?? $qResp['data'] ?? [];

        // Users
        $users = [
            ['code' => 1, 'name' => 'Admin'],
        ];

        return view('crm.transactions.quotation_followup.form', compact(
            'followup', 'vwedt', 'quotations', 'users', 'parentFollowup'
        ));
    }

    public function saveQuotationFollowup(Request $request, QuotationFollowupService $qfs)
    {
        $intno  = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        $data = [
            'quotationintno'     => $request->input('quotationintno'),
            'followup_date'      => $request->input('followup_date'),
            'next_followup_date' => $request->input('next_followup_date'),
            'followup_mode'      => $request->input('followup_mode', 'CALL'),
            'remarks'            => $request->input('remarks'),
            'status'             => $request->input('status', 'OPEN'),
            'usercd'             => $usercd
        ];

        $resp = $qfs->putQuotationFollowup($intno, $data);
        return response()->json($resp);
    }

    public function statQuotationFollowup(QuotationFollowupService $qfs, $intno, $actyn)
    {
        $res = $qfs->quotationFollowupStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('quotationFollowup')->with('success', $res['data']['message']);
        else
            return redirect()->Route('quotationFollowup')->with('error', $res['data']['message']);
    }

    public function printQuotationFollowupList(QuotationFollowupService $qfs)
    {
        $response  = $qfs->getQuotationFollowupList(0, 'Y');
        $followups = $response['data']['data'] ?? [];

        return view('crm.transactions.quotation_followup.print', compact('followups'));
    }
}