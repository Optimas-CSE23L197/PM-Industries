<?php
namespace App\Services;

class CompanyService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function saveComp( array $payload){
        $aedl = $payload['code'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'code' => $payload['code'] ?? '',
                    'name' => $payload['name'] ?? '',
                    'address' => $payload['address'] ?? '',
                    'phone' => $payload['phone'] ?? '',
                    'mobile' => $payload['mobile'] ?? '',
                    'emailid' => $payload['emailid'] ?? '',
                    'finyr' => $payload['finyr'] ?? '0000',
                    'fdt' => $payload['fdt'] ?? '0000-00-00',
                    'tdt' => $payload['tdt'] ?? '0000-00-00',
                    'gststatecd' => $payload['gststatecd'] ?? '',
                    'gstno' => $payload['gstno'] ?? '',
                    'lockdt' => $payload['lockdt'] ?? '0000-00-00',
                    'other_credentials' => $payload['other_credentials'] ?? '',
                    'activeyn'=> $payload['activeyn'] ?? 'Y'

                 ];
        return $this->api->get('company.php', $param);
    }

    public function statComp( $aedl, $code ){
        $param = ['aedl'=>$aedl, 'code'=>$code];
        return $this->api->get('company.php', $param);
    }
}