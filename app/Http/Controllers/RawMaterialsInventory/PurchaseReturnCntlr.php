<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseReturnCntlr extends Controller
{
    public function getList(){
        return view('rawMaterialsInventory.transactions.purchaseReturn.index');
    }

    public function getPrint(){
        $compnm = session('compNmC');
        return view('rawMaterialsInventory.transactions.purchaseReturn.print' ,compact('compnm'));
    }

    public function getDetails( $mode, $code=0 ){
        return view('rawMaterialsInventory.transactions.purchaseReturn.form', compact('mode'));
    }
}
