<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\OpeningStkService;

class OpeningStkCntlr extends Controller
{
    public function getList( OpeningStkService $os ){
        $opstk = $os->getList( 0, 'Y' )['data'] ?? [];
        return view('rawMaterialsInventory.masters.openingStock.index', compact('opstk'));
    }

    public function getPrint( OpeningStkService $os ){
        $resp = $os->getList( 0, 'Y')['data'] ?? [];
        $compnm =  session('compNmC');
        return view('rawMaterialsInventory.masters.openingStock.print', compact('resp', 'compnm'));
    }
    
    public function getDetails( OpeningStkService $os, $mode, $code=0 ){
        $opstk = null;
        if($code){
            $opstk = $os->getList( 0, 'Y')['data'][0] ?? [];
        }
        //return view('rawMaterialsInventory.masters.openingStock.form', compact('opstk','mode'));
    }

    public function saveOpStk( Request $r, OpeningStkService $os ){
        try{
            $payload = $r->all();
            $resp = $os->saveOpStk( $payload );
            return response()->json( $resp );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => true, 'message'=> $e->getMessage()], 500);
        }
    }
    
    public function statOpStk( OpeningStkService $os, $code, $aedl ){
        $res = $os->statOpStk( $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.opStkList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.opStkList')->with('error', $res['message']);
    }
}
