<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payroll\WorkerAdvanceService;
use App\Services\Payroll\ContractorService;
use App\Services\Payroll\WorkerService;
use App\Services\Payroll\ContractorBillService;

class WorkerAdvanceCntlr extends Controller
{
    public function workerAdvance(WorkerAdvanceService $was)
    {
        $advances = $was->getWorkerAdvanceList(0, 'Y');
        $advances = $advances['data']['data'] ?? [];

        return view('payroll.transactions.worker_advance.index', compact('advances'));
    }

    public function workerAdvanceDetails(
        WorkerAdvanceService $was,
        ContractorService $cs,
        WorkerService $ws,
        ContractorBillService $cbs,
        $vwedt = null,
        $intno = null
    ) {
        $advance = [];
        if ($intno) {
            $advance = $was->getWorkerAdvanceList($intno, 'N');
            $advance = $advance['data']['data'][0] ?? [];
        }

        $contractors = $cs->getContractorList(0, 'N');
        $contractors = $contractors['data'] ?? [];

        $workers = $ws->getWorkerList(0, 'N');
        $workers = $workers['data'] ?? [];

        $bills = $cbs->getContractorBillList(0, 'N');
        $bills = $bills['data']['data'] ?? [];

        return view('payroll.transactions.worker_advance.form',
            compact('advance', 'contractors', 'workers', 'bills', 'vwedt'));
    }

    public function saveWorkerAdvance(Request $request, WorkerAdvanceService $was)
    {
        $intno = $request->input('intno', 0);

        $data = [
            'advance_date'      => $request->input('advance_date'),
            'contractorcd'      => $request->input('contractorcd'),
            'workercd'          => $request->input('workercd'),
            'amount'            => $request->input('amount', 0),
            'adjustment_amount' => $request->input('adjustment_amount', 0),
            'balance_amount'    => $request->input('balance_amount', 0),
            'contractorbillcd'  => $request->input('contractorbillcd'),
            'usercd'            => session('userCdC') ?? 1,
        ];

        $resp = $was->putWorkerAdvance($intno, $data);
        // dd($resp);
        return response()->json($resp);
    }

    public function statWorkerAdvance(WorkerAdvanceService $was, $intno, $actyn)
    {
        $res = $was->workerAdvanceStat($intno, $actyn);

        if (!$res['error'])
            return redirect()->route('payroll.workerAdvance')->with('success', $res['data']['message']);
        else
            return redirect()->route('payroll.workerAdvance')->with('error', $res['data']['message']);
    }

    public function printWorkerAdvanceList(WorkerAdvanceService $was)
    {
        $advances = $was->getWorkerAdvanceList(0, 'Y');
        $advances = $advances['data']['data'] ?? [];

        return view('payroll.transactions.worker_advance.print', compact('advances'));
    }
}