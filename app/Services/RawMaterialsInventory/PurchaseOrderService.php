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

    public function savePurchaseOrder( $compcd,$usercd, array $payload ){
        $aedl = $payload['intno'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'compcd'=> $compcd,
                    'intno' => $payload['intno'] ?? '',
                    'po_no' => $payload['po_no'] ?? '',
                    'po_date' => $payload['po_date'] ??'',
                    'suppliercd' => $payload['suppliercd'] ?? '',
                    'expected_date' => $payload['expected_date'] ?? '',
                    'status' => $payload['status'] ?? 'OPEN',
                    'remarks' => $payload['remarks'] ?? '',
                    'gross' => $payload['gross'] ?? 0.00,
                    'gstamt' => $payload['gstamt'] ?? 0.00,
                    'roundoff' => $payload['roundoff'] ?? 0.00,
                    'netamt' => $payload['netamt'] ?? 0.00,
                    'items'=> $payload['items'] ?? [],
                    'usercd'=> $usercd,
                    'activeyn' => $payload['activeyn'] ?? 'Y'
                 ];
        return $this->api->get('purchase_order.php', $param);
    }

    public function statPurchaseOrder( $compcd, $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'compcd' => $compcd,
                    'intno' => $code
                 ];
        return $this->api->get('purchase_order.php', $param);
    }
}