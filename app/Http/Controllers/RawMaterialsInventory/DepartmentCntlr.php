<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\DepartmentService;

class DepartmentCntlr extends Controller
{
    public function getList( DepartmentService $ds ){
        $deprt = $ds->getList( 0, 'Y' )['data'] ?? [];
        return view('rawMaterialsInventory.masters.department.index', compact('deprt'));
    }

    public function getPrint( DepartmentService $ds ){
        $resp = $ds->getList( 0, 'Y' )['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.masters.department.print', compact('resp', 'compnm'));
    }

    public function getDetails( DepartmentService $ds, $mode, $code=0 ){
        $deprt = null;
        if($code){
            $deprt = $ds->getList( $code, 'Y' )['data'][0] ?? [];
        }
        return view('rawMaterialsInventory.masters.department.form', compact('deprt', 'mode'));
    }

    public function saveDepartment( DepartmentService $ds, Request $r ){
        try{
            $payload = $r->all();
            $resp = $ds->saveDepartment( $payload );
            return response()->json($resp);
        }
        catch(\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function statDepartment( DepartmentService $ds, $code, $aedl ){
        $res = $ds->statDepartment( $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.departmentList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.departmentList')->with('error', $res['message']);
    }
}
