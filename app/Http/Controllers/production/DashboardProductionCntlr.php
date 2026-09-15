<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardProductionCntlr extends Controller
{
    public function production() {
        return view('productions.index');
    }
}
