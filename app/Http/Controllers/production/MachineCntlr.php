<?php
namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Production\MachineService;

class MachineCntlr extends Controller
{
    public function machine(MachineService $ms)
    {
        $machines = $ms->getMachineList(0, session('compCdC') ?? 1, 'Y');
        $machines = $machines['data'] ?? [];

        return view('productions.masters.machine.index', compact('machines'));
    }

    public function machineDetails(MachineService $ms, $vwedt = null, $code = null)
    {
        $machine = [];
        if ($code) {
            $machine = $ms->getMachineList($code, session('compCdC') ?? 1, 'N');
            $machine = $machine['data'][0] ?? [];
        }

        return view('productions.masters.machine.form', compact('machine', 'vwedt'));
    }

    public function saveMachine(Request $request, MachineService $ms)
    {
        $code                    = $request->input('code', 0);
        $name                    = $request->input('name');
        $model_no                = $request->input('model_no');
        $serial_no               = $request->input('serial_no');
        $installation_date       = $request->input('installation_date');
        $maintenance_period_days = $request->input('maintenance_period_days');
        $next_maintenance_date   = $request->input('next_maintenance_date');

        $resp = $ms->putMachine(
            session('compCdC') ?? 1, 
            $code, 
            $name, 
            $model_no, 
            $serial_no, 
            $installation_date, 
            $maintenance_period_days, 
            $next_maintenance_date
        );

        return response()->json($resp);
    }

    public function statMachine(MachineService $ms, $code, $actyn)
    {
        $res = $ms->machineStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('machine')->with('success', $res['message']);
        else
            return redirect()->Route('machine')->with('error', $res['message']);
    }

    public function printMachineList(MachineService $ms)
    {
        $machines = $ms->getMachineList(0, session('compCdC') ?? 1, 'Y');
        $machines = $machines['data'] ?? [];

        return view('productions.masters.machine.print', compact('machines'));
    }
}