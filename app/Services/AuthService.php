<?php

namespace App\Services;

class AuthService
{
    protected $api;
    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function userVerify( array $payload ) {
        $param = [
                    'name'      => $payload['username'],
                    'password'  => $payload['password']
                 ];
        $res = $this->api->get('loginuser.php', $param);

        return $res;
    }

    public function uverify($name, $password){
        $compgrpcd = session('compgrpCdC');
        if($compgrpcd == ''){$compgrpcd = 0;}
        $res = $this->api->get('loginuser.php',[
            'name' => $name,
            'password' => $password,
            'compgrpcd' => $compgrpcd
        ]);
        return $res;
    }
}
