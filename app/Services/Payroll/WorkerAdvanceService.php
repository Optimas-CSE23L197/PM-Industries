<?php

namespace App\Services\Payroll;

use App\Services\ApiClient;

class WorkerAdvanceService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getWorkerAdvanceList($intno = 0, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'intno'   => $intno,
            'showall' => $showall,
        ];

        return $this->api->get('worker_advance.php', $param);
    }

    public function putWorkerAdvance($intno, $data)
    {
        $aedl = $intno == 0 ? 'A' : 'E';

        $param = [
            'aedl'              => $aedl,
            'intno'             => $intno,
            'advance_date'      => $data['advance_date'] ?? '',
            'contractorcd'      => $data['contractorcd'] ?? '',
            'workercd'          => $data['workercd'] ?? '',
            'amount'            => $data['amount'] ?? 0,
            'adjustment_amount' => $data['adjustment_amount'] ?? 0,
            'balance_amount'    => $data['balance_amount'] ?? 0,
            'contractorbillcd'  => $data['contractorbillcd'] ?? '',
            'usercd'            => $data['usercd'] ?? '',
        ];

        return $this->api->get('worker_advance.php', $param);
    }

    public function workerAdvanceStat($intno, $actyn)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'  => $aedl,
            'intno' => $intno,
        ];

        return $this->api->get('worker_advance.php', $param);
    }
}