<?php

namespace App\Services\Payroll;

use App\Services\ApiClient;

class ContractorService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getContractorList($code = 0, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'showall' => $showall,
        ];

        return $this->api->get('contractor.php', $param);
    }

    public function putContractor($code, $data)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = array_merge([
            'aedl' => $aedl,
            'code' => $code,
        ], $data);

        return $this->api->get('contractor.php', $param);
    }

    public function contractorStat($code, $actyn)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl' => $aedl,
            'code' => $code,
        ];

        return $this->api->get('contractor.php', $param);
    }
}