<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class StockAdjService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getList( $code, $showall){
        $param = [
                    'aedl' => 'L',
                    'showall' => $showall
                 ];
        if( $code != 0 && $code != ''){
            $param['intno'] = $code;
        }
        return $this->api->get('stock_adjustment.php', $param);
    }

    public function saveStkAdj( $usercd, array $payload ){
        $aedl = $payload['intno'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'intno' => $payload['intno'] ?? '',
                    'adjdt' => $payload['adjdt'] ?? '',
                    'adjno' => $payload['adjno'] ??'',
                    'reason' => $payload['reason'] ?? '',
                    'usercd' => $usercd,
                    'items'=> $payload['items'] ?? [],
                    'activeyn' => $payload['activeyn'] ?? 'Y'
                 ];
        // dd($param);
        return $this->api->get('stock_adjustment.php', $param);
    }

    public function statStkAdj( $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'intno' => $code
                 ];
        return $this->api->get('stock_adjustment.php', $param);
    }
}