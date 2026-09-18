<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class SalesService
{
    protected $api;
    protected $trantype = 'SALE';

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /**
     * Get list (all active or showall)
     */
    public function getSalesList($intno = 0, $showall = 'Y')
    {
        $param = [
            'aedl'     => 'L',
            'trantype' => $this->trantype
        ];

        if ($intno) $param['intno'] = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';

        return $this->api->get('salepurc.php', $param);
    }

    /**
     * Add / Edit
     */
    public function putSales($intno, $data)
    {
        $aedl = $intno == 0 ? 'A' : 'E';

        $param = array_merge([
            'aedl'     => $aedl,
            'trantype' => $this->trantype,
            'intno'    => $intno
        ], $data);

        return $this->api->get('salepurc.php', $param);
    }

    /**
     * Activate / Deactivate
     */
    public function salesStat($intno, $actyn)
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