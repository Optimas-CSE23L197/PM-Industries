<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class EnquiryService
{
    protected $api;

    public function __construct(ApiClient $api) { $this->api = $api; }

    public function getEnquiryList($intno = 0, $compcd = 1, $showall = 'Y')
    {
        $param = ['aedl' => 'L'];
        if ($intno)    $param['intno']   = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('enquiry.php', $param);
    }

    public function putEnquiry($compcd, $intno, $data)
    {
        $aedl  = $intno == 0 ? 'A' : 'E';
        $param = array_merge([
            'aedl'   => $aedl,
            'compcd' => $compcd,
            'intno'  => $intno
        ], $data);
        return $this->api->get('enquiry.php', $param);
    }

    public function enquiryStat($intno, $actyn, $compcd = 1)
    {
        $aedl  = $actyn == 'Y' ? 'D' : 'U';
        $param = ['aedl' => $aedl, 'intno' => $intno];
        return $this->api->get('enquiry.php', $param);
    }
}