<?php

namespace App\Http\Controllers;
use App\Services\{ MasterService, CompanyService };

use Illuminate\Http\Request;

class CompanyCntlr extends Controller{
    public function getCompany( MasterService $mast ){
        $comp = $mast->getCompany('Y')['data'] ?? [];
        return view('company.index', compact('comp'));
    }

    public function getdetails( MasterService $mast, $mode, $code=null ){
        $comp = null;
        if($code){
            $comp = $mast->getCompany('Y')['data'][0] ?? [];
        }
        return view('company.form', compact('comp', 'mode'));
    }

    public function saveComp( CompanyService $cs, Request $r ){
        try{
            $payload = $r->all();
            $resp = $cs->saveComp( $payload );
            return response()->json($resp);
        } catch( \Throwable $e ){
            $resp = ['error'=>true, 'message'=>'Unable to save company. Please try again.'];
            return response()->json($resp, 500);
        }
    }

    public function statComp( CompanyService $cs, $code, $aedl ){
        $res = $cs->statComp($aedl, $code);
        if(!$res['error'])
            return redirect()->Route('compList')->with('success', $res['message']);
        else
            return redirect()->Route('compList')->with('error', $res['message']);
    }
}
