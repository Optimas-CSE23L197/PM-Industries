<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\{ Issue_ReturnService, DepartmentService, RawItemService };

class IssueToDeptCntlr extends Controller
{
    public function getList( Issue_ReturnService $irs ){
        $ir = $irs->getList( 0, 'I', 'Y')['data']['data'] ?? [];
        return view('rawMaterialsInventory.transactions.issueToDepartments.index', compact('ir'));
    }

    public function getPrint( Issue_ReturnService $irs ){
        $resp = $irs->getList( 0, 'I', 'Y')['data']['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.issueToDepartments.print', compact('resp', 'compnm'));
    }

    public function getDetails( Issue_ReturnService $irs, DepartmentService $ds, RawItemService $ris, $mode, $code=0){
        $deprt = $ds->getList( 0, 'N' )['data'] ?? [];
        $rawItm = $ris->getList( 0, 'Y' )['data'] ?? [];
        $ir = null;
        if( $code ){
            $ir = $irs->getList( $code, 'I', 'Y')['data']['data'][0] ?? [];
        }
        return view('rawMaterialsInventory.transactions.issueToDepartments.form', compact('ir', 'mode', 'deprt', 'rawItm'));
    }

    public function saveIssuetoDept( Request $r, Issue_ReturnService $irs ){
        try{
            $payload = $r->all();
            $res = $irs->saveIssueRtn( session('userCdC'), 'I', $payload )['data'];

            if( isset( $res['intno'] ) && $res['intno'] && $res['status'])
                $resp = ['error'=>false, 'message'=>$res['message']];
            else
                $resp = ['error'=>true, 'message'=>$res['message']];

            return response()->json( $resp );
        }
        catch ( \Exception $e ) {
            return response()->json(['error'=>true, 'message'=>$e->getMessage()], 500);
        }
    }
    
    public function statIssueToDept( Issue_ReturnService $irs, $code, $aedl ){
        $resp = $irs->statIssueRtn( $code, $aedl, 'I' )['data'];

        if( isset( $resp['intno'] ) && $resp['intno'] && $resp['status'])
            $res = ['error'=>false, 'message'=>$resp['message']];
        else
            $res = ['error'=>true, 'message'=>$resp['message']];

        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.issueToDeptList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.issueToDeptList')->with('error', $res['message']);
    }
}
