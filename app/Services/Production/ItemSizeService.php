<?php
namespace App\Services\Production;

use App\Services\ApiClient;

class ItemSizeService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getItemSizeList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('size.php', $param);
    }

    public function putItemSize($compcd, $code, $name)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'   => $aedl,
            'compcd' => $compcd,
            'code'   => $code,
            'name'   => $name
        ];

        return $this->api->get('size.php', $param);
    }

    public function itemSizeStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('size.php', $param);
    }
}