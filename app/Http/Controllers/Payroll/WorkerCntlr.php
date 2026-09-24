<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payroll\WorkerService;
use App\Services\Payroll\ContractorService;

class WorkerCntlr extends Controller
{
    public function worker(WorkerService $ws)
    {
        $workers = $ws->getWorkerList(0, 'Y');
        $workers = $workers['data'] ?? [];

        return view('payroll.masters.worker.index', compact('workers'));
    }

    public function workerDetails(WorkerService $ws, ContractorService $cs, $vwedt = null, $code = null)
    {
        $worker = [];
        if ($code) {
            $worker = $ws->getWorkerList($code, 'N');
            $worker = $worker['data'][0] ?? [];
        }

        $contractors = $cs->getContractorList(0, 'Y');
        $contractors = $contractors['data'] ?? [];

        return view('payroll.masters.worker.form', compact('worker', 'contractors', 'vwedt'));
    }

    public function saveWorker(Request $request, WorkerService $ws)
    {
        $code = $request->input('code', 0);

        $data = [
            'name'         => $request->input('name'),
            'contractorcd' => $request->input('contractorcd'),
            'activeyn'     => $request->input('activeyn', 'Y'),
        ];

        $resp = $ws->putWorker($code, $data);

        return response()->json($resp);
    }

    public function statWorker(WorkerService $ws, $code, $actyn)
    {
        $res = $ws->workerStat($code, $actyn);

        if (!$res['error'])
            return redirect()->route('payroll.worker')->with('success', $res['message']);
        else
            return redirect()->route('payroll.worker')->with('error', $res['message']);
    }

    public function printWorkerList(WorkerService $ws)
    {
        $workers = $ws->getWorkerList(0, 'Y');
        $workers = $workers['data'] ?? [];

        return view('payroll.masters.worker.print', compact('workers'));
    }
}