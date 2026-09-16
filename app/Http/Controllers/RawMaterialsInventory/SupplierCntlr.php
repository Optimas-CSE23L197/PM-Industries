<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\SupplierService;

class SupplierCntlr extends Controller
{
    public function getList( SupplierService $ss){
        $splr = $ss->getList( 0, 'Y')['data'] ?? [];
        return view('rawMaterialsInventory.masters.supplier.index', compact('splr'));
    }

    public function getprint( SupplierService $ss ){
        $resp = $ss->getList( 0, 'Y')['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.masters.supplier.print', compact('resp', 'compnm'));
    }

    public function getDetails( SupplierService $ss, $mode, $code=0 ){
        $splr = null;
        if($code){
            $splr = $ss->getList( $code, 'Y')['data'][0] ?? [];
        }
        return view('rawMaterialsInventory.masters.supplier.form', compact('splr', 'mode'));
    }

    public function saveSupplier( SupplierService $ss, Request $r ){
        try{
            $payload = $r->all();
            $resp = $ss->saveSupplier( $payload );
            return response()->json($resp);
        }
        catch(\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
    

    public function statSupplier( SupplierService $ss, $code, $aedl ){
        $res = $ss->statSupplier( $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.supplierList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.supplierList')->with('error', $res['message']);
    }
}