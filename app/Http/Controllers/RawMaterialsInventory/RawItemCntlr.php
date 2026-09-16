<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\{ RawItemService, RawItemTypeService };

class RawItemCntlr extends Controller
{
    public function getList( RawItemService $ris ){
        $rawItems = $ris->getList( 0, 'Y' )['data'] ?? [];
        return view('rawMaterialsInventory.masters.rawItem.index', compact('rawItems'));
    }

    public function getprint( RawItemService $ris ){
        $resp = $ris->getList( 0, 'Y' )['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.masters.rawItem.print', compact('resp', 'compnm'));
    }

    public function getDetails( RawItemService $ris, RawItemTypeService $rmts, $mode, $code = null ){
        $rmType = $rmts->getList( 0, 'Y' )['data'] ?? [];
        $rawItem = null;
        if($code){
            $rawItem = $ris->getList( $code, 'Y' )['data'][0] ?? [];
        }
        return view('rawMaterialsInventory.masters.rawItem.form', compact('rawItem', 'mode', 'rmType'));
    }

    public function saveRawItem( RawItemService $ris, Request $r ){
        try{
            $payload = $r->all();
            $resp = $ris->saveRawItem( $payload );
            return response()->json($resp);
        } catch( \Throwable $e ){
            $resp = ['error'=>true, 'message'=>'Unable to save raw item. Please try again.'];
            return response()->json($resp, 500);
        }
    }

    public function statRawItem( RawItemService $ris, $code, $aedl ){
        $res = $ris->statRawItem( $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.rawItemList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.rawItemList')->with('error', $res['message']);
    }
}
