<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class EnquiryFollowupService
{
    protected $api;

    public function __construct(ApiClient $api) { $this->api = $api; }

    public function getEnquiryFollowupList($intno = 0, $showall = 'Y')
    {
        $param = ['aedl' => 'L'];
        if ($intno) $param['intno'] = $intno;
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('enquiry_followup.php', $param);
    }

    public function getFollowupByEnquiry($enquiryintno, $showall = 'Y')
    {
        $param = ['aedl' => 'L', 'enquiryintno' => $enquiryintno];
        if ($showall === 'Y') $param['showall'] = 'Y';
        return $this->api->get('enquiry_followup.php', $param);
    }

    public function putEnquiryFollowup($intno, $data)
    {
        $aedl  = $intno == 0 ? 'A' : 'E';
        $param = array_merge(['aedl' => $aedl, 'intno' => $intno], $data);
        return $this->api->get('enquiry_followup.php', $param);
    }

    public function enquiryFollowupStat($intno, $actyn)
    {
        $aedl  = $actyn == 'Y' ? 'D' : 'U';
        $param = ['aedl' => $aedl, 'intno' => $intno];
        return $this->api->get('enquiry_followup.php', $param);
    }
}