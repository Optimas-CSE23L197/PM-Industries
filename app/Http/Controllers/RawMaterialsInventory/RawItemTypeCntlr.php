<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\RawItemTypeService;

class RawItemTypeCntlr extends Controller{
    public function index( RawItemTypeService $rmt ){
        $rmType = $rmt->getList( 0, 'Y' )['data'] ?? [];
        return view('rawMaterialsInventory.masters.rawItemType.index', compact('rmType'));
    }
    public function getDetails( RawItemTypeService $rmt, $mode, $code = null ){
        $rmType = null;
        if($code){
            $rmType = $rmt->getList( $code, 'Y' )['data'][0] ?? [];
        }
        return view('rawMaterialsInventory.masters.rawItemType.form', compact('rmType', 'mode'));
    }

    public function saveRawMaterialType( RawItemTypeService $rmt, Request $r ){
        try{
            $payload = $r->all();
            $resp = $rmt->saveRawMaterialType( $payload );
            return response()->json($resp);
        } catch( \Throwable $e ){
            $resp = ['error'=>true, 'message'=>'Unable to save raw material type. Please try again.'];
            return response()->json($resp, 500);
        }
    }

    public function statRawMaterialType( RawItemTypeService $rmt, $code, $aedl ){
        $res = $rmt->statRawMaterialType( $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.rawMaterialTypeList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.rawMaterialTypeList')->with('error', $res['message']);
    }
}
