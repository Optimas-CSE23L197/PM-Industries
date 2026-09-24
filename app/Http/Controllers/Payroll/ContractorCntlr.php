<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payroll\ContractorService;

class ContractorCntlr extends Controller
{
    public function contractor(ContractorService $cs)
    {
        $contractors = $cs->getContractorList(0, 'Y');
        $contractors = $contractors['data'] ?? [];
        // dd($contractors);

        return view('payroll.masters.contractor.index', compact('contractors'));
    }

    public function contractorDetails(ContractorService $cs, $vwedt = null, $code = null)
    {
        $contractor = [];
        if ($code) {
            $contractor = $cs->getContractorList($code, 'N');
            $contractor = $contractor['data'][0] ?? [];
        }

        return view('payroll.masters.contractor.form', compact('contractor', 'vwedt'));
    }

    public function saveContractor(Request $request, ContractorService $cs)
    {
        $code = $request->input('code', 0);

        $data = [
            'name'     => $request->input('name'),
            'address'  => $request->input('address'),
            'phone'    => $request->input('phone'),
            'email'    => $request->input('email'),
            'opbal'    => $request->input('opbal', 0),
            'activeyn' => $request->input('activeyn', 'Y'),
        ];

        $resp = $cs->putContractor($code, $data);

        return response()->json($resp);
    }

    public function statContractor(ContractorService $cs, $code, $actyn)
    {
        $res = $cs->contractorStat($code, $actyn);
        if (!$res['error'])
            return redirect()->route('payroll.contractor')->with('success', $res['message']);
        else
            return redirect()->route('payroll.contractor')->with('error', $res['message']);
    }

    public function printContractorList(ContractorService $cs)
    {
        $contractors = $cs->getContractorList(0, 'Y');
        $contractors = $contractors['data'] ?? [];

        return view('payroll.masters.contractor.print', compact('contractors'));
    }
}