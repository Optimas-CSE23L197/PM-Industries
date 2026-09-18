<?php
namespace App\Services\Production;

use App\Services\ApiClient;

class BomService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getBomList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('bom.php', $param);
    }

    public function getBomListByFinishedItem($finisheditemcd, $compcd)
    {
        $param = [
            'aedl'           => 'L',
            'finisheditemcd' => $finisheditemcd,
            'compcd'         => $compcd
        ];

        return $this->api->get('bom.php', $param);
    }

    public function putBom($compcd, $code, $finisheditemcd, $qty, $userid, $bomdtl)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'           => $aedl,
            'compcd'         => $compcd,
            'code'           => $code,
            'finisheditemcd' => $finisheditemcd,
            'qty'            => $qty,
            'userid'         => $userid,
            'bomdtl'         => $bomdtl
        ];

        return $this->api->get('bom.php', $param);
    }

    public function bomStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('bom.php', $param);
    }
}