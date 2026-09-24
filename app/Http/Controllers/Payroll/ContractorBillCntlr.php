<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payroll\ContractorBillService;
use App\Services\Payroll\ContractorService;

class ContractorBillCntlr extends Controller
{
    public function contractorBill(ContractorBillService $cbs)
    {
        $bills = $cbs->getContractorBillList(0, 'Y');
        $bills = $bills['data']['data'] ?? [];

        return view('payroll.transactions.contractor_bill.index', compact('bills'));
    }

    public function contractorBillDetails(ContractorBillService $cbs, ContractorService $cs, $vwedt = null, $intno = null)
    {
        $bill = [];
        if ($intno) {
            $bill = $cbs->getContractorBillList($intno, 'N');
            $bill = $bill['data']['data'][0] ?? [];
        }

        $contractors = $cs->getContractorList(0, 'N');
        $contractors = $contractors['data'] ?? [];

        return view('payroll.transactions.contractor_bill.form', compact('bill', 'contractors', 'vwedt'));
    }

    public function saveContractorBill(Request $request, ContractorBillService $cbs)
    {
        $intno = $request->input('intno', 0);

        $data = [
            'companycd'          => session('compCdC') ?? 1,
            'bill_date'          => $request->input('bill_date'),
            'contractorcd'       => $request->input('contractorcd'),
            'gross_amount'       => $request->input('gross_amount', 0),
            'advance_adjustment' => $request->input('advance_adjustment', 0),
            'approval_status'    => $request->input('approval_status', 'PENDING'),
            'approved_by'        => $request->input('approved_by'),
            'approved_at'        => $request->input('approved_at'),
        ];

        $resp = $cbs->putContractorBill($intno, $data);

        return response()->json($resp);
    }

    public function statContractorBill(ContractorBillService $cbs, $intno, $actyn)
    {
        $res = $cbs->contractorBillStat($intno, $actyn);

        if (!$res['error'])
            return redirect()->route('payroll.contractorBill')->with('success', $res['data']['message']);
        else
            return redirect()->route('payroll.contractorBill')->with('error', $res['data']['message']);
    }

    public function printContractorBillList(ContractorBillService $cbs)
    {
        $bills = $cbs->getContractorBillList(0, 'Y');
        $bills = $bills['data']['data'] ?? [];

        return view('payroll.transactions.contractor_bill.print', compact('bills'));
    }
}