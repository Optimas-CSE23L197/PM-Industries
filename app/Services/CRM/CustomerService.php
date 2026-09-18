<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class CustomerService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getCustomerList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('customer.php', $param);
    }

    public function putCustomer($compcd, $code, $data)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = array_merge([
            'aedl'   => $aedl,
            'compcd' => $compcd,
            'code'   => $code
        ], $data);

        return $this->api->get('customer.php', $param);
    }

    public function customerStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('customer.php', $param);
    }
}