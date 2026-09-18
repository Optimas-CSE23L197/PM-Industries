<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class QuotationFollowupService
{
    protected $api;

    public function __construct(ApiClient $api) { $this->api = $api; }

    public function getQuotationFollowupList($intno = 0, $showall = 'Y')
    {
        $param = ['aedl' => 'L'];
        if ($intno) $param['intno'] = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('quotation_followup.php', $param);
    }

    public function getQuotationFollowupSingle($intno, $showall = 'N')
    {
        $param = ['aedl' => 'L', 'intno' => $intno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('quotation_followup.php', $param);
    }

    public function getFollowupByQuotation($quotationintno, $showall = 'Y')
    {
        $param = ['aedl' => 'L', 'quotationintno' => $quotationintno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('quotation_followup.php', $param);
    }

    public function putQuotationFollowup($intno, $data)
    {
        $aedl  = $intno == 0 ? 'A' : 'E';
        $param = array_merge(['aedl' => $aedl, 'intno' => $intno], $data);
        return $this->api->get('quotation_followup.php', $param);
    }

    public function quotationFollowupStat($intno, $actyn)
    {
        $aedl  = $actyn == 'Y' ? 'D' : 'U';
        $param = ['aedl' => $aedl, 'intno' => $intno];
        return $this->api->get('quotation_followup.php', $param);
    }
}