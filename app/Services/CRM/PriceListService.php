<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class PriceListService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getPriceList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('ratelist.php', $param);
    }

    public function putPriceList($compcd, $code, $name, $valid_from, $valid_to, $details)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'       => $aedl,
            'compcd'     => $compcd,
            'code'       => $code,
            'name'       => $name,
            'valid_from' => $valid_from,
            'valid_to'   => $valid_to,
            'details'    => $details
        ];

        return $this->api->get('ratelist.php', $param);
    }

    public function priceListStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('ratelist.php', $param);
    }
}