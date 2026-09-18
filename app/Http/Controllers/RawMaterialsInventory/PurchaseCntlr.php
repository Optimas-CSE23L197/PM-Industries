<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\{ PurchaseService, SupplierService, RawItemService };

class PurchaseCntlr extends Controller
{
    public function getList( PurchaseService $ps ){
        $purc = $ps->getList( 'PURC', 0, 'Y' )['data']['data'] ?? [];
        return view('rawMaterialsInventory.transactions.purchase.index', compact('purc'));
    }

    public function getPrint( PurchaseService $ps ){
        $resp = $ps->getList( 'PURC', 0, 'Y' )['data']['data'] ?? [];
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.purchase.print', compact('compnm', 'resp'));
    }

    public function getDetails( PurchaseService $ps, SupplierService $ss, RawItemService $rs, $mode, $code=0 ){
        $rawItm = $rs->getList( 0, 'N' )['data'] ?? [];
        $splr = $ss->getList( 0, 'N')['data'] ?? [];
        $purc = null;
        if( $code )
            $purc = $ps->getList( 'PURC', 0, 'Y' )['data']['data'][0] ?? [];
        return view('rawMaterialsInventory.transactions.purchase.form', compact('mode', 'splr', 'purc', 'rawItm'));
    }

    public function savePurchase( Request $r, PurchaseService $ps ){
        try{
            $payload = $r->all();
            $res = $ps->savePurchase( session('userCdC'), 'I', $payload )['data'];

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
    
    public function statPurchase( PurchaseService $ps, $code, $aedl ){
        $resp = $ps->sataPurchase( 'PURC', $code, $aedl )['data'];

        if( isset( $resp['intno'] ) && $resp['intno'] && $resp['status'])
            $res = ['error'=>false, 'message'=>$resp['message']];
        else
            $res = ['error'=>true, 'message'=>$resp['message']];

        if(!$res['error'])
            return redirect()->Route('rawMaterialsInventory.purchaseList')->with('success', $res['message']);
        else
            return redirect()->Route('rawMaterialsInventory.purchaseList')->with('error', $res['message']);
    }
}
