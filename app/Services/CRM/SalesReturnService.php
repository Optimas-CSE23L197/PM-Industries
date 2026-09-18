<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class SalesReturnService
{
    protected $api;
    protected $trantype = 'SRET';

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getSalesReturnList($intno = 0, $showall = 'Y')
    {
        $param = [
            'aedl'     => 'L',
            'trantype' => $this->trantype
        ];

        if ($intno) {
            $param['intno'] = $intno;
        }
        if ($showall === 'Y') {
            $param['showall'] = 'Y';
        }

        return $this->api->get('salepurc.php', $param);
    }

    public function putSalesReturn($intno, $data)
    {
        $aedl = $intno == 0 ? 'A' : 'E';

        $param = array_merge([
            'aedl'     => $aedl,
            'trantype' => $this->trantype,
            'intno'    => $intno
        ], $data);

        return $this->api->get('salepurc.php', $param);
    }

    public function salesReturnStat($intno, $actyn)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'     => $aedl,
            'trantype' => $this->trantype,
            'intno'    => $intno
        ];

        return $this->api->get('salepurc.php', $param);
    }
}