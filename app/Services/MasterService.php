<?php
namespace App\Services;

class MasterService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getCompany( $showall ){
        $param = ['aedl'=>'L', 'showall'=>$showall];
        return $this->api->get('company.php', $param);
    }
}