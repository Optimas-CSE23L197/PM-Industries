<?php
namespace App\Services\Production;

use App\Services\ApiClient;

class FinishedItemService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getFinishedItemList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('finished_item.php', $param);
    }

    public function putFinishedItem($compcd, $code, $name, $unit, $standard_cost)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'          => $aedl,
            'compcd'        => $compcd,
            'code'          => $code,
            'name'          => $name,
            'unit'          => $unit,
            'standard_cost' => $standard_cost
        ];

        return $this->api->get('finished_item.php', $param);
    }

    public function finishedItemStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('finished_item.php', $param);
    }
}