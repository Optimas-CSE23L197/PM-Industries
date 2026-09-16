<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RawMaterialsInventory\PurchaseService;

class PurchaseCntlr extends Controller
{
    public function getList( PurchaseService $ps ){
        //$purc = $ps->getList();
        return view('rawMaterialsInventory.transactions.purchase.index');
    }

    public function getPrint( PurchaseService $ps ){
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.purchase.print', compact('compnm'));
    }

    public function getDetails( PurchaseService $ps, $mode, $code=0 ){
        return view('rawMaterialsInventory.transactions.purchase.form', compact('mode'));
    }
}
