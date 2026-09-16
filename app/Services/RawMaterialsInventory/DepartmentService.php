<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class DepartmentService{
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
        return $this->api->get('department.php', $param);
    }

    public function saveDepartment( array $payload ){
        $aedl = $payload['code'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'code' => $payload['code'] ?? '',
                    'name' => $payload['name'] ?? '',
                    'active_yn' => $payload['active_yn'] ?? 'Y'
                 ];
        return $this->api->get('department.php', $param);
    }

    public function statDepartment( $code, $aedl ){
        $param = [
                    'aedl' => $aedl,
                    'code' => $code
                 ];
        return $this->api->get('department.php', $param);
    }
}