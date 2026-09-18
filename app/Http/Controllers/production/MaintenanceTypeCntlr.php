<?php
namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Production\MaintenanceTypeService;

class MaintenanceTypeCntlr extends Controller
{
    public function maintenanceType(MaintenanceTypeService $mts)
    {
        $maintenanceTypes = $mts->getMaintenanceTypeList(0, session('compCdC') ?? 1, 'Y');
        $maintenanceTypes = $maintenanceTypes['data'] ?? [];

        return view('productions.masters.maintenance_type.index', compact('maintenanceTypes'));
    }

    public function maintenanceTypeDetails(MaintenanceTypeService $mts, $vwedt = null, $code = null)
    {
        $maintenanceType = [];
        if ($code) {
            $maintenanceType = $mts->getMaintenanceTypeList($code, session('compCdC') ?? 1, 'N');
            $maintenanceType = $maintenanceType['data'][0] ?? [];
        }

        return view('productions.masters.maintenance_type.form', compact('maintenanceType', 'vwedt'));
    }

    public function saveMaintenanceType(Request $request, MaintenanceTypeService $mts)
    {
        $code = $request->input('code', 0);
        $name = $request->input('name');

        $resp = $mts->putMaintenanceType(session('compCdC') ?? 1, $code, $name);

        return response()->json($resp);
    }

    public function statMaintenanceType(MaintenanceTypeService $mts, $code, $actyn)
    {
        $res = $mts->maintenanceTypeStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('maintenanceType')->with('success', $res['message']);
        else
            return redirect()->Route('maintenanceType')->with('error', $res['message']);
    }

    public function printMaintenanceTypeList(MaintenanceTypeService $mts)
    {
        $maintenanceTypes = $mts->getMaintenanceTypeList(0, session('compCdC') ?? 1, 'Y');
        $maintenanceTypes = $maintenanceTypes['data'] ?? [];

        return view('productions.masters.maintenance_type.print', compact('maintenanceTypes'));
    }
}