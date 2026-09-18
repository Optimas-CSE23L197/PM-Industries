<?php
namespace App\Services\Production;

use App\Services\ApiClient;

class MachineService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getMachineList($code, $compcd, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'code'    => $code,
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        return $this->api->get('machine.php', $param);
    }

    public function putMachine($compcd, $code, $name, $model_no, $serial_no, $installation_date, $maintenance_period_days, $next_maintenance_date)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'                    => $aedl,
            'compcd'                  => $compcd,
            'code'                    => $code,
            'name'                    => $name,
            'model_no'                => $model_no,
            'serial_no'               => $serial_no,
            'installation_date'       => $installation_date,
            'maintenance_period_days' => $maintenance_period_days,
            'next_maintenance_date'   => $next_maintenance_date
        ];

        return $this->api->get('machine.php', $param);
    }

    public function machineStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('machine.php', $param);
    }
}