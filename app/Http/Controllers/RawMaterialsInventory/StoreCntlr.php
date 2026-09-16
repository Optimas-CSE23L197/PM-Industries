<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\StoreService;

class StoreCntlr extends Controller
{
    public function getList( StoreService $st ){
        //$store = $st->getList( 0, 'Y' )['data'] ?? [];
        return view('rawMaterialsInventory.masters.store.index', /*compact('store')*/);
    }

    public function getPrint( StoreService $st ){
        //$resp = $st->getList( 0, 'Y')['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.masters.store.print', compact('compnm'/*, 'resp'*/));
    }

    public function getDetails( StoreService $st, $mode, $code=0 ){
        // $store = null;
        // if($code){
        //     $store = $st->getList( 0, 'Y')['data'][0] ?? [];
        // }
        return view('rawMaterialsInventory.masters.store.form', compact(/*'store',*/ 'mode'));
    }

    public function saveStore( Request $r, StoreService $st ){
        try{
            $payload = $r->all();
            $resp = $st->saveStore( $payload );
            return response()->json( $resp );
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message'=> $e->getMessage()], 500);
        }
    }
    
    public function statStore( StoreService $st, $code, $aedl ){
        $res = $st->statStore( $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.storeList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.storeList')->with('error', $res['message']);
    }
    
}
