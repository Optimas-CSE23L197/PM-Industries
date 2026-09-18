<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class SalesOrderService
{
    protected $api;

    public function __construct(ApiClient $api) { $this->api = $api; }

    public function getSalesOrderList($intno = 0, $showall = 'Y')
    {
        $param = ['aedl' => 'L'];
        if ($intno) $param['intno'] = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('sales_order.php', $param);
    }

    public function getSalesOrderSingle($intno, $showall = 'N')
    {
        $param = ['aedl' => 'L', 'intno' => $intno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('sales_order.php', $param);
    }

    public function putSalesOrder($intno, $data)
    {
        $aedl  = $intno == 0 ? 'A' : 'E';
        $param = array_merge(['aedl' => $aedl, 'intno' => $intno], $data);
        return $this->api->get('sales_order.php', $param);
    }

    public function salesOrderStat($intno, $actyn)
    {
        $aedl  = $actyn == 'Y' ? 'D' : 'U';
        $param = ['aedl' => $aedl, 'intno' => $intno];
        return $this->api->get('sales_order.php', $param);
    }
}