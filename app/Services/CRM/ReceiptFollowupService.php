<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class ReceiptFollowupService
{
    protected $api;

    public function __construct(ApiClient $api) { $this->api = $api; }

    public function getReceiptFollowupList($intno = 0, $showall = 'Y')
    {
        $param = ['aedl' => 'L'];
        if ($intno) $param['intno'] = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('receipt_followup.php', $param);
    }

    public function getReceiptFollowupSingle($intno, $showall = 'N')
    {
        $param = ['aedl' => 'L', 'intno' => $intno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('receipt_followup.php', $param);
    }

    public function getFollowupByBill($billintno, $showall = 'Y')
    {
        $param = ['aedl' => 'L', 'billintno' => $billintno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('receipt_followup.php', $param);
    }

    public function putReceiptFollowup($intno, $data)
    {
        $aedl  = $intno == 0 ? 'A' : 'E';
        $param = array_merge(['aedl' => $aedl, 'intno' => $intno], $data);
        return $this->api->get('receipt_followup.php', $param);
    }

    public function receiptFollowupStat($intno, $actyn)
    {
        $aedl  = $actyn == 'Y' ? 'D' : 'U';
        $param = ['aedl' => $aedl, 'intno' => $intno];
        return $this->api->get('receipt_followup.php', $param);
    }
}