<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCrmCntlr extends Controller
{
    public function crm() {
        return view('crm.dashboard');
    }
}
