<?php
namespace App\Services\Production;

use App\Services\ApiClient;

class FinishedItemTypeService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getFinishedItemTypeList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('finished_item_type.php', $param);
    }

    public function putFinishedItemType($compcd, $code, $name)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'   => $aedl,
            'compcd' => $compcd,
            'code'   => $code,
            'name'   => $name
        ];

        return $this->api->get('finished_item_type.php', $param);
    }

    public function finishedItemTypeStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('finished_item_type.php', $param);
    }
}