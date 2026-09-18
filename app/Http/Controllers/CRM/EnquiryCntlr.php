<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Services\Crm\{CustomerService,LeadSourceService};
use App\Services\Production\{FinishedItemService,ItemSizeService};
use Illuminate\Http\Request;
use App\Services\Crm\EnquiryService;

class EnquiryCntlr extends Controller
{
    public function enquiry(EnquiryService $es)
    {
        $response  = $es->getEnquiryList(0, session('compCdC') ?? 1, 'Y');
        $enquiries = $response['data']['data'] ?? [];
        // dd($enquiries);
        return view('crm.transactions.enquiry.index', compact('enquiries'));
    }

    public function enquiryDetails(
        EnquiryService $es,
        CustomerService $cs,
        LeadSourceService $lss,
        FinishedItemService $fis,
        ItemSizeService $iss,
        $vwedt = null,
        $intno = null
    ) {
        $enquiry = [];
        if ($intno) {
            $response = $es->getEnquiryList($intno, session('compCdC') ?? 1, 'N');
            $enquiry = $response['data']['data'][0] ?? [];
        }
            
        $customers = $cs->getCustomerList(0, session('compCdC') ?? 1, 'Y');
        $customers = $customers['data']['data'] ?? $customers['data'] ?? [];

        $leadSources = $lss->getLeadSourceList(0, session('compCdC') ?? 1, 'Y');
        $leadSources = $leadSources['data']['data'] ?? $leadSources['data'] ?? [];

        $finishedItems = $fis->getFinishedItemList(0, session('compCdC') ?? 1, 'Y');
        $finishedItems = $finishedItems['data']['data'] ?? $finishedItems['data'] ?? [];

        $itemSizes = $iss->getItemSizeList(0, session('compCdC') ?? 1, 'Y');
        $itemSizes = $itemSizes['data']['data'] ?? $itemSizes['data'] ?? [];

        return view('crm.transactions.enquiry.form', compact(
            'enquiry', 'vwedt', 'customers', 'leadSources', 'finishedItems', 'itemSizes'
        ));
    }

    public function saveEnquiry(Request $request, EnquiryService $es)
    {
        $intno = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        // Build items JSON
        $itemsArr = [];
        foreach ($request->input('items', []) as $row) {
            if (empty($row['finisheditemcd']) || empty($row['qty'])) continue;
            $itemsArr[] = [
                'finisheditemcd' => (int) $row['finisheditemcd'],
                'sizecd'         => (int) ($row['sizecd'] ?? 0),
                'qty'            => (float) $row['qty'],
                'target_rate'    => (float) ($row['target_rate'] ?? 0),
                'remarks'        => $row['remarks'] ?? ''
            ];
        }

        if (empty($itemsArr)) {
            return response()->json(['error' => true, 'message' => 'Please add at least one item.']);
        }

        $data = [
            'enquiry_date'        => $request->input('enquiry_date'),
            'customercd'          => $request->input('customercd'),
            'leadsourcecd'        => $request->input('leadsourcecd'),
            'status'              => $request->input('status', 'OPEN'),
            'expected_order_date' => $request->input('expected_order_date'),
            'remarks'             => $request->input('remarks'),
            'usercd'              => $usercd,
            'items'               => json_encode($itemsArr)
        ];

        $resp = $es->putEnquiry(session('compCdC') ?? 1, $intno, $data);
        return response()->json($resp);
    }

    public function statEnquiry(EnquiryService $es, $intno, $actyn)
    {
        $res = $es->enquiryStat($intno, $actyn, session('compCdC') ?? 1);
        if (!$res['error'])
            return redirect()->Route('enquiry')->with('success', $res['data']['message']);
        else
            return redirect()->Route('enquiry')->with('error', $res['data']['message']);
    }

    public function printEnquiryList(EnquiryService $es)
    {
        $enquiries = $es->getEnquiryList(0, session('compCdC') ?? 1, 'Y');
        $enquiries = $enquiries['data']['data'] ?? [];
        return view('crm.transactions.enquiry.print', compact('enquiries'));
    }
}