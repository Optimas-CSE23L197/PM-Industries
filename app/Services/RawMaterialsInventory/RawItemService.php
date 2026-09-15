<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class RawItemService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getList( $code, $showall){
        $param = [
                    'aedl' => 'L',
                    'code' => $code,
                    'showall' => $showall
                 ];
        return $this->api->get('rawitem.php', $param);
    }

    public function saveRawItem( array $payload ){
        $aedl = $payload['code'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'code' => $payload['code'] ?? '',
                    'name' => $payload['name'] ?? '',
                    'typecd' => $payload['typecd'] ?? '',
                    'reorder_level' => $payload['reorder_level'] ?? 0,
                    'min_stock' => $payload['min_stock'] ?? 0,
                    'lastpurrate' => $payload['lastpurrate'] ?? 0,
                    'active_yn' => $payload['active_yn'] ?? 'Y'
                 ];
        return $this->api->get('rawitem.php', $param);
    }

    public function statRawItem( $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'code' => $code
                 ];
        return $this->api->get('rawitem.php', $param);
    }
}