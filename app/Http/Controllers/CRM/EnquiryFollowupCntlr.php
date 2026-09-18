<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\EnquiryFollowupService;
use App\Services\Crm\EnquiryService;

class EnquiryFollowupCntlr extends Controller
{
    public function enquiryFollowup(EnquiryFollowupService $efs)
    {
        $followups = $efs->getEnquiryFollowupList(0, 'Y');
        $followups = $followups['data']['data'] ?? [];
        return view('crm.transactions.enquiry_followup.index', compact('followups'));
    }

    public function enquiryFollowupDetails(
        EnquiryFollowupService $efs,
        EnquiryService $es,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $enquiryintno       = $request->input('enquiryintno');
        $parentFollowupIntno = $request->input('parent_followup_intno');

        $followup       = [];
        $parentFollowup = [];

        // Case 1: Edit / View existing followup
        if ($intno) {
            $response = $efs->getEnquiryFollowupList($intno, 'N');
            $followup = $response['data']['data'][0] ?? [];
        }
        // Case 2: Followup of Followup (vwedt = 4)
        elseif ($vwedt == 4 && $parentFollowupIntno) {
            // Fetch parent followup details
            $parentResp     = $efs->getEnquiryFollowupList($parentFollowupIntno, 'N');
            $parentFollowup = $parentResp['data']['data'][0] ?? [];

            // Pre-fill enquiry (locked) from parent
            $followup['enquiryintno'] = $parentFollowup['enquiryintno'] ?? $enquiryintno;

            $followup['followup_date']      = date('Y-m-d');
            $followup['next_followup_date'] = $parentFollowup['next_followup_date'] ?? '';
            $followup['assigned_to']        = $parentFollowup['assigned_to'] ?? '';
            $followup['status']             = $parentFollowup['status'] ?? 'OPEN';
        }
        // Case 3: Followup from Enquiry (vwedt = 3)
        elseif ($vwedt == 3 && $enquiryintno) {
            $enqResp = $es->getEnquiryList($enquiryintno, session('compCdC') ?? 1, 'N');
            $enqData = $enqResp['data']['data'][0] ?? $enqResp['data'][0] ?? [];

            $followup['enquiryintno']  = $enquiryintno;
            $followup['enquiry_no']    = $enqData['enquiry_no'] ?? '';
            $followup['customer_name'] = $enqData['customer_name'] ?? '';
            $followup['enquiry_date']  = $enqData['enquiry_date'] ?? '';
        }

        // Dropdowns
        $enqList   = $es->getEnquiryList(0, session('compCdC') ?? 1, 'Y');
        $enquiries = $enqList['data']['data'] ?? $enqList['data'] ?? [];

        // Users
        $users = [
            ['code' => 1, 'name' => 'Admin'],
        ];

        return view('crm.transactions.enquiry_followup.form', compact(
            'followup', 'vwedt', 'enquiries', 'users', 'parentFollowup'
        ));
    }

    public function saveEnquiryFollowup(Request $request, EnquiryFollowupService $efs)
    {
        $intno  = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        $followupDate = $request->input('followup_date');
        if ($followupDate) {
            $followupDate = str_replace('T', ' ', $followupDate);
            if (strlen($followupDate) == 16) {  // 'Y-m-d H:i' → add ':00'
                $followupDate .= ':00';
            }
        }

        $data = [
            'enquiryintno'       => $request->input('enquiryintno'),
            'followup_date'      => $followupDate,
            'next_followup_date' => $request->input('next_followup_date'),
            'followup_mode'      => $request->input('followup_mode'),
            'remarks'            => $request->input('remarks'),
            'status'             => $request->input('status', 'OPEN'),
            'assigned_to'        => $request->input('assigned_to'),
            'usercd'             => $usercd
        ];

        $resp = $efs->putEnquiryFollowup($intno, $data);
        // dd($resp);
        return response()->json($resp);
    }

    public function statEnquiryFollowup(EnquiryFollowupService $efs, $intno, $actyn)
    {
        $res = $efs->enquiryFollowupStat($intno, $actyn);
        // dd($res);
        if (!$res['error'])
            return redirect()->Route('enquiryFollowup')->with('success', $res['data']['message']);
        else
            return redirect()->Route('enquiryFollowup')->with('error', $res['data']['message']);
    }

    public function printEnquiryFollowupList(EnquiryFollowupService $efs)
    {
        $followups = $efs->getEnquiryFollowupList(0, 'Y');
        $followups = $followups['data']['data'] ?? [];
        return view('crm.transactions.enquiry_followup.print', compact('followups'));
    }
}