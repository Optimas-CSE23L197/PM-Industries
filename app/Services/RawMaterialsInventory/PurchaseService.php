<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class PurchaseService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getList( $trantype, $intno, $showall){
        // dd($intno);
        $param = [
                    'aedl' => 'L',
                    'trantype'=> $trantype,
                    'intno' => $intno,
                    'showall' => $showall
                 ];
        // dd($param);
        return $this->api->get('salepurc.php', $param);
    }

    public function savePurchase( $compcd,$usercd, array $payload ){
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
        return $this->api->get('salepurc.php', $param);
    }

    public function sataPurchase( $trantype, $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'trantype' => $trantype,
                    'intno' => $code
                 ];
        return $this->api->get('salepurc.php', $param);
    }
}