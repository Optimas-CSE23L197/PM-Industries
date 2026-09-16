<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class PurchaseOrderService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getList( $compcd, $code, $showall){
        // dd($code);
        $param = [
                    'aedl' => 'L',
                    'compcd'=> $compcd,
                    'intno' => $code,
                    'showall' => $showall
                 ];
        // dd($param);
        return $this->api->get('purchase_order.php', $param);
    }

    public function savePurchaseOrder( array $payload ){
        $aedl = $payload['code'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'intno' => $payload['code'] ?? '',
                    'name' => $payload['name'] ?? '',
                    'active_yn' => $payload['active_yn'] ?? 'Y'
                 ];
        return $this->api->get('purchase_order.php', $param);
    }

    public function sataPurchaseOrder( $compcd, $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'compcd' => $compcd,
                    'intno' => $code
                 ];
        return $this->api->get('purchase_order.php', $param);
    }
}