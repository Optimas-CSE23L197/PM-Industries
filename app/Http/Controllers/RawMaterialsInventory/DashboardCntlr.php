<?php

namespace App\Http\Controllers\RawMaterialsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCntlr extends Controller
{
    public function dashboard()
    {
        return view('rawMaterialsInventory.dashboard');
    }
}
