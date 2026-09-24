<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayrollDashboardCntlr extends Controller
{
    public function payroll() {
        return view('payroll.dashboard');
    }
}
