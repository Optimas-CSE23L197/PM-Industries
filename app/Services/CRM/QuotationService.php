<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class QuotationService
{
    protected $api;

    public function __construct(ApiClient $api) { $this->api = $api; }

    public function getQuotationList($intno = 0, $showall = 'Y')
    {
        $param = ['aedl' => 'L'];
        if ($intno) $param['intno'] = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('quotation.php', $param);
    }

    public function getQuotationSingle($intno, $showall = 'N')
    {
        $param = ['aedl' => 'L', 'intno' => $intno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('quotation.php', $param);
    }

    public function putQuotation($compcd, $intno, $data)
    {
        $aedl  = $intno == 0 ? 'A' : 'E';
        $param = array_merge([
            'aedl'   => $aedl,
            'compcd' => $compcd,
            'intno'  => $intno
        ], $data);
        return $this->api->get('quotation.php', $param);
    }

    public function quotationStat($intno, $actyn)
    {
        $aedl  = $actyn == 'Y' ? 'D' : 'U';
        $param = ['aedl' => $aedl, 'intno' => $intno];
        return $this->api->get('quotation.php', $param);
    }
}