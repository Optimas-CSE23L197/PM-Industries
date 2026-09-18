<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\QuotationService;
use App\Services\Crm\EnquiryService;
use App\Services\Crm\TermsConditionsService;
use App\Services\Crm\PriceListService;
use App\Services\Production\FinishedItemService;
use App\Services\Production\ItemSizeService;

class QuotationCntlr extends Controller
{
    public function quotation(QuotationService $qs)
    {
        $response   = $qs->getQuotationList(0, 'Y');
        $quotations = $response['data']['data'] ?? $response['data'] ?? [];

        return view('crm.transactions.quotation.index', compact('quotations'));
    }

    public function quotationDetails(
        QuotationService $qs,
        EnquiryService $es,
        TermsConditionsService $tcs,
        PriceListService $pls,
        FinishedItemService $fis,
        ItemSizeService $iss,
        Request $request,
        $vwedt = null,
        $intno = null
    ) {
        $enquiryIntno = $request->input('enquiryintno');
        $quotation    = [];

        // View / Edit existing
        if ($intno) {
            $response  = $qs->getQuotationList($intno, 'Y');
            $quotation = $response['data']['data'][0] ?? $response['data'][0] ?? [];
        }
        // From Enquiry (vwedt = 3)
        elseif ($vwedt == 3 && $enquiryIntno) {
            $enqResp = $es->getEnquiryList($enquiryIntno, session('compCdC') ?? 1, 'N');
            $enqData = $enqResp['data']['data'][0] ?? $enqResp['data'][0] ?? [];

            $quotation['enquiryintno']  = $enquiryIntno;
            $quotation['customercd']    = $enqData['customercd'] ?? '';
            $quotation['customer_name'] = $enqData['customer_name'] ?? '';
            $quotation['quotation_date']= date('Y-m-d');
            $quotation['items']         = $enqData['items'] ?? [];
        }

        // Dropdowns
        $enqList   = $es->getEnquiryList(0, session('compCdC') ?? 1, 'Y');
        $enquiries = $enqList['data']['data'] ?? $enqList['data'] ?? [];

        $tcResp = $tcs->getTermsConditions(0, session('compCdC') ?? 1, 'Y');
        $terms  = $tcResp['data']['data'] ?? $tcResp['data'] ?? [];

        $plResp    = $pls->getPriceList(0, session('compCdC') ?? 1, 'Y');
        $rateLists = $plResp['data']['data'] ?? $plResp['data'] ?? [];

        $fiResp = $fis->getFinishedItemList(0, session('compCdC') ?? 1, 'Y');
        $items  = $fiResp['data']['data'] ?? $fiResp['data'] ?? [];

        $isResp = $iss->getItemSizeList(0, session('compCdC') ?? 1, 'Y');
        $sizes  = $isResp['data']['data'] ?? $isResp['data'] ?? [];

        return view('crm.transactions.quotation.form', compact(
            'quotation', 'vwedt', 'enquiries', 'terms', 'rateLists', 'items', 'sizes'
        ));
    }

    public function saveQuotation(Request $request, QuotationService $qs)
    {
        $intno  = $request->input('intno', 0);
        $usercd = session('userId') ?? 1;

        $itemsArr = [];
        foreach ($request->input('items', []) as $row) {
            if (empty($row['finisheditemcd']) || empty($row['qty'])) continue;

            $itemsArr[] = [
                'finisheditemcd' => (int) $row['finisheditemcd'],
                'sizecd'         => (int) ($row['sizecd'] ?? 0),
                'description'    => $row['description'] ?? '',
                'qty'            => (float) $row['qty'],
                'rate'           => (float) ($row['rate'] ?? 0),
                'discount'       => (float) ($row['discount'] ?? 0),
                'gstrt'          => (float) ($row['gstrt'] ?? 0),
                'usercd'         => $usercd
            ];
        }

        if (empty($itemsArr)) {
            return response()->json(['error' => true, 'message' => 'Please add at least one item.']);
        }

        $data = [
            'quotation_date'    => $request->input('quotation_date'),
            'customercd'        => $request->input('customercd'),
            'enquiryintno'      => $request->input('enquiryintno'),
            'quotation_termscd' => $request->input('quotation_termscd'),
            'ratelistcd'        => $request->input('ratelistcd'),
            'valid_until'       => $request->input('valid_until'),
            'status'            => $request->input('status', 'DRAFT'),
            'remarks'           => $request->input('remarks'),
            'usercd'            => $usercd,
            'items'             => json_encode($itemsArr)
        ];

        $resp = $qs->putQuotation(session('compCdC') ?? 1, $intno, $data);
        return response()->json($resp);
    }

    public function statQuotation(QuotationService $qs, $intno, $actyn)
    {
        $res = $qs->quotationStat($intno, $actyn);
        if (!$res['error'])
            return redirect()->Route('quotation')->with('success', $res['data']['message']);
        else
            return redirect()->Route('quotation')->with('error', $res['data']['message']);
    }

    public function printQuotationList(QuotationService $qs)
    {
        $response   = $qs->getQuotationList(0, 'Y');
        $quotations = $response['data']['data'] ?? [];

        return view('crm.transactions.quotation.print', compact('quotations'));
    }
}