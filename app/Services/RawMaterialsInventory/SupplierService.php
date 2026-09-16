<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class SupplierService{
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
        return $this->api->get('supplier.php', $param);
    }

    public function saveSupplier( array $payload ){
        $aedl = $payload['code'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'code' => $payload['code'] ?? '',
                    'name' => $payload['name'] ?? '',
                    'address1' => $payload['address1'] ?? '',
                    'gstin' => $payload['gstin'] ?? '',
                    'pan_no' => $payload['pan_no'] ?? '',
                    'contact_person' => $payload['contact_person'] ?? '',
                    'phone'=> $payload['phone'] ?? '',
                    'email'=> $payload['email'] ?? '',
                    'credit_days'=> $payload['credit_days'] ?? '',
                    'opening_balance'=> $payload['opening_balance'] ?? '',
                    'active_yn' => $payload['active_yn'] ?? 'Y'
                 ];
        return $this->api->get('supplier.php', $param);
    }

    public function statSupplier( $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'code' => $code
                 ];
        return $this->api->get('supplier.php', $param);
    }
}