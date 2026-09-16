<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\{ PurchaseOrderService, SupplierService, RawItemService };

class PurchaseOrderCntlr extends Controller
{
    public function getList( PurchaseOrderService $pos ){
        $prOdr = $pos->getList( session('compCdC'), 0, 'Y' )['data'] ?? [];
        return view('rawMaterialsInventory.transactions.purchaseOrder.index', compact('prOdr'));
    }

    public function getPrint( PurchaseOrderService $pos ){
        $resp = $pos->getList( session('compCdC'), 0, 'Y')['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.purchaseOrder.print', compact('resp', 'compnm'));
    }
    
    public function getDetails( PurchaseOrderService $pos, SupplierService $ss, RawItemService $ris, $mode, $code=0 ){
        $splr = $ss->getList( 0, 'N')['data'] ?? [];
        $rawItems = $ris->getList( 0, 'N' )['data'] ?? [];
        $prOdr = null;
        if($code){
            $prOdr = $pos->getList( session('compCdC'), $code, 'Y')['data'] ?? [];
        }
        // dd($prOdr);
        return view('rawMaterialsInventory.transactions.purchaseOrder.form', compact('prOdr','mode', 'splr', 'rawItems'));
    }
    
    public function savePurchaseOrder( Request $r, PurchaseOrderService $pos ){
        try {
            // dd($r->all());
            $payload = $r->all();
            $resp = $pos->savePurchaseOrder( session('compCdC'), session('userCdC'), $payload );
            return response()->json( $resp );
        } catch ( \Exception $e ) {
            return response()->json(['error'=>true, 'message'=>$e->getMessage()], 500);
        }
    }

    public function sataPurchaseOrder( PurchaseOrderService $pos, $code, $aedl ){
        $res = $pos->sataPurchaseOrder( session('compCdC'), $code, $aedl );
        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.purchaseOrderList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.purchaseOrderList')->with('error', $res['message']);
    }
    
}