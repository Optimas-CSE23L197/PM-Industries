<?php

namespace App\Services\Payroll;

use App\Services\ApiClient;

class WorkerService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getWorkerList($code = 0, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'showall' => $showall,
        ];

        return $this->api->get('workers.php', $param);
    }

    public function putWorker($code, $data)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'         => $aedl,
            'code'         => $code,
            'name'         => $data['name'] ?? '',
            'contractorcd' => $data['contractorcd'] ?? '',
            'activeyn'     => $data['activeyn'] ?? 'Y',
        ];

        return $this->api->get('workers.php', $param);
    }

    public function workerStat($code, $actyn)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl' => $aedl,
            'code' => $code,
        ];

        return $this->api->get('workers.php', $param);
    }
}