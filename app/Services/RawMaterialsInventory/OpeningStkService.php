<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class OpeningStkService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getList( $code, $showall){
        $param = [
                    'aedl' => 'L',
                    'intno' => $code,
                    'showall' => $showall
                 ];
        return $this->api->get('opstock.php', $param);
    }

    public function saveOpStk( array $payload ){
        $aedl = $payload['code'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'intno' => $payload['intno'] ?? '',
                    'name' => $payload['name'] ?? '',
                    'qty' => $payload['qty'] ?? '',
                    'rate' => $payload['rate'] ?? '',
                    'activeyn' => $payload['activeyn'] ?? 'Y'
                 ];
        return $this->api->get('opstock.php', $param);
    }

    public function statOpStk( $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'intno' => $code
                 ];
        return $this->api->get('opstock.php', $param);
    }
}