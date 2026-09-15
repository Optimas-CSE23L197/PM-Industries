<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\{ AuthService, MasterService };

class AuthCntlr extends Controller
{
    public function userLogin(){
        return view( 'login.user_login' );
    }

    public function userVerify ( Request $r, AuthService $as ){
        $payload = $r->all();
        $uLogin = $as -> userVerify( $payload );
        if($uLogin['error']){
            return back()->with('error', $uLogin['message']);
        }
        $data = $uLogin['data'][0] ?? null;
        if(!$data){
            return back()->with('error', 'Invalid Login!!!');
        }
        session([
                    'user'       => true,
                    'userCdC' => $data['usercd'],
                    'userNmC' => $data['usernm']
                ]);
        return redirect()->Route('companyLogin');
    }

    public function companyLogin( MasterService $gc ){
        $comp = $gc->getCompany( 'N' )['data'] ?? [];
        // dd($comp);
        return view( 'login.company_login', compact('comp') );
    }

    public function selectComp( Request $r ){
        $comp = explode('|', $r->company_id);
        $compcd = trim($comp[0]);
        $compnm = trim($comp[1]);
        session([
                    'compCdC' => $compcd,
                    'compNmC' => $compnm
                ]);
        return redirect()->Route('chooseDept');
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->Route('/userLogin');
    }
}
