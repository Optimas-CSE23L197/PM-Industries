<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\TermsConditionsService;

class TermsConditionsCntlr extends Controller
{
    public function termsConditions(TermsConditionsService $tcs)
    {
        $compcd = session('compCdC') ?? 1;

        // Fetch all T&C rows grouped by qid
        $response = $tcs->getTermsConditionsList($compcd, null, 'Y');
        $rows     = $response['data'] ?? [];

        // Group by qid — pick the latest (or first) for each
        $terms = [
            'quotation' => '',
            'invoice'   => '',
            'delivery'  => '',
        ];

        foreach ($rows as $row) {
            $qid = strtoupper($row['qid'] ?? '');
            if ($qid === 'Q' && empty($terms['quotation'])) {
                $terms['quotation'] = $row['term_text'] ?? '';
            } elseif ($qid === 'I' && empty($terms['invoice'])) {
                $terms['invoice'] = $row['term_text'] ?? '';
            } elseif ($qid === 'D' && empty($terms['delivery'])) {
                $terms['delivery'] = $row['term_text'] ?? '';
            }
        }

        return view('crm.masters.term_and_conditions.form', compact('terms'));
    }

    public function saveTermsConditions(Request $request, TermsConditionsService $tcs)
    {
        $compcd = session('compCdC') ?? 1;

        $quotation = $request->input('quotation');
        $invoice   = $request->input('invoice');
        $delivery  = $request->input('delivery');

        // Get existing codes for each type (if any)
        $existing = $tcs->getTermsConditionsList($compcd, null, 'Y');
        $rows     = $existing['data'] ?? [];

        $codeMap = [
            'Q' => 0,
            'I' => 0,
            'D' => 0,
        ];

        foreach ($rows as $row) {
            $qid = strtoupper($row['qid'] ?? '');
            if (isset($codeMap[$qid]) && $codeMap[$qid] === 0) {
                $codeMap[$qid] = $row['code'] ?? 0;
            }
        }

        $results = [];

        // Save each type separately
        if (!empty($quotation)) {
            $results[] = $tcs->putTermsConditions($compcd, $codeMap['Q'], 'Q', $quotation);
        }
        if (!empty($invoice)) {
            $results[] = $tcs->putTermsConditions($compcd, $codeMap['I'], 'I', $invoice);
        }
        if (!empty($delivery)) {
            $results[] = $tcs->putTermsConditions($compcd, $codeMap['D'], 'D', $delivery);
        }

        // Combine results
        $hasError = false;
        $messages = [];
        foreach ($results as $r) {
            if (!empty($r['error'])) {
                $hasError = true;
                $messages[] = $r['message'] ?? 'Error';
            } else {
                $messages[] = $r['message'] ?? 'Success';
            }
        }

        return response()->json([
            'error'   => $hasError,
            'message' => implode('<br>', $messages)
        ]);
    }
}