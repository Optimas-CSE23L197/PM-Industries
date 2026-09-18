<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\CustomerService;

class CustomerCntlr extends Controller
{
    public function customer(CustomerService $cs)
    {
        $customers = $cs->getCustomerList(0, session('compCdC') ?? 1, 'Y');
        $customers = $customers['data'] ?? [];

        return view('crm.masters.customer.index', compact('customers'));
    }

    public function customerDetails(CustomerService $cs, $vwedt = null, $code = null)
    {
        $customer = [];
        if ($code) {
            $customer = $cs->getCustomerList($code, session('compCdC') ?? 1, 'N');
            $customer = $customer['data'][0] ?? [];
        }

        return view('crm.masters.customer.form', compact('customer', 'vwedt'));
    }

    public function saveCustomer(Request $request, CustomerService $cs)
    {
        $code = $request->input('code', 0);

        $data = [
            'name'            => $request->input('name'),
            'contact_person'  => $request->input('contact_person'),
            'phone'           => $request->input('phone'),
            'address'         => $request->input('address'),
            'gstin'           => $request->input('gstin'),
            'pan_no'          => $request->input('pan_no'),
            'email'           => $request->input('email'),
            'credit_days'     => $request->input('credit_days'),
            'opening_balance' => $request->input('opening_balance')
        ];

        $resp = $cs->putCustomer(session('compCdC') ?? 1, $code, $data);

        return response()->json($resp);
    }

    public function statCustomer(CustomerService $cs, $code, $actyn)
    {
        $res = $cs->customerStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('customer')->with('success', $res['message']);
        else
            return redirect()->Route('customer')->with('error', $res['message']);
    }

    public function printCustomerList(CustomerService $cs)
    {
        $customers = $cs->getCustomerList(0, session('compCdC') ?? 1, 'Y');
        $customers = $customers['data'] ?? [];

        return view('crm.masters.customer.print', compact('customers'));
    }
}