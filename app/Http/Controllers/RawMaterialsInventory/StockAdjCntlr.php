<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\{ StockAdjService, DepartmentService, RawItemService };

class StockAdjCntlr extends Controller
{
    public function getList( StockAdjService $sa ){
        $stkAdj = $sa->getList( 0, 'Y' )['data']['data'] ?? [];
        return view('rawMaterialsInventory.transactions.stockAdjustment.index', compact('stkAdj'));
    }

    public function getPrint( StockAdjService $sa ){
        $resp = $sa->getList( 0, 'Y' )['data']['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.stockAdjustment.print', compact('resp', 'compnm'));
    }

    public function getDetails( StockAdjService $sa, DepartmentService $ds, RawItemService $ris, $mode, $code=0 ){
        $deprt = $ds->getList( 0, 'N' )['data'] ?? [];
        $rawItems = $ris->getList( 0, 'N' )['data'] ?? [];
        $stkAdj = null; 
        if($code)
            $stkAdj = $sa->getList( 0, 'Y' )['data']['data'][0] ?? [];
        return view('rawMaterialsInventory.transactions.stockAdjustment.form', compact('stkAdj', 'mode', 'deprt', 'rawItems'));
    }

    public function saveStkAdj( StockAdjService $sa, Request $r ){
        try{
            $payload = $r->all();
            $res = $sa->saveStkAdj( session('userCdC'), $payload )['data'];

            if( isset( $res['intno'] ) && $res['intno'] && $res['status'])
                $resp = ['error'=>false, 'message'=>$res['message']];
            else
                $resp = ['error'=>true, 'message'=>$res['message']];
            
            return response()->json( $resp );
        } catch ( \Exception $e ) {
            return response()->json(['error'=>true, 'message'=>$e->getMessage()], 500);
        }
    }

    public function statStkAdj( StockAdjService $sa, $code, $aedl){
        $res = $sa->statStkAdj( $code, $aedl );
        // dd($res);
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.stkAdjList')->with('success', $res['data']['message']);
        else
            return redirect()->Route('rawMaterialsInventory.stkAdjList')->with('error', $res['data']['message']);
    }
}