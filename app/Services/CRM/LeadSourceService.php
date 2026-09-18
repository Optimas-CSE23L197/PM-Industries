<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class LeadSourceService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getLeadSourceList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('lead_source.php', $param);
    }

    public function putLeadSource($compcd, $code, $name)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'   => $aedl,
            'compcd' => $compcd,
            'code'   => $code,
            'name'   => $name
        ];

        return $this->api->get('lead_source.php', $param);
    }

    public function leadSourceStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('lead_source.php', $param);
    }
}