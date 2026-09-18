<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\Issue_ReturnService;

class ReturnFrmDeptCntlr extends Controller
{
    public function getList( Issue_ReturnService $irs ){
        $rtn = $irs->getList( 0, 'R', 'Y')['data']['data'] ?? [];
        return view('rawMaterialsInventory.transactions.returnFromDepartments.index', compact('rtn'));
    }

    public function getPrint( Issue_ReturnService $irs ){
        $resp = $irs->getList( 0, 'R', 'Y')['data']['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.returnFromDepartments.print', compact('compnm', 'resp'));
    }

    public function getDetails( Issue_ReturnService $irs, $mode, $code=0){
        $ir = $irs->getList( 0, 'I', 'N')['data']['data'] ?? [];
        $rtn = null;
        if( $code )
            $rtn = $irs->getList( 0, 'R', 'Y')['data']['data'][0] ?? [];
        return view('rawMaterialsInventory.transactions.returnFromDepartments.form', compact('rtn', 'mode', 'ir'));
    }

    public function saveRtnfrmDept( Request $r, Issue_ReturnService $irs ){
        try{
            $payload = $r->all();
            $res = $irs->saveIssueRtn( session('userCdC'), 'R', $payload )['data'];

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
    
    public function statRtnFrmDept( Issue_ReturnService $irs, $code, $aedl ){
        $resp = $irs->statIssueRtn( $code, $aedl, 'R' )['data'];

        if( isset( $resp['intno'] ) && $resp['intno'] && $resp['status'])
            $res = ['error'=>false, 'message'=>$resp['message']];
        else
            $res = ['error'=>true, 'message'=>$resp['message']];

        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.rtnFrmDeptList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.rtnFrmDeptList')->with('error', $res['message']);
    }
}
