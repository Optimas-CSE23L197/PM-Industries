<?php

namespace App\Services\Payroll;

use App\Services\ApiClient;

class ContractorBillService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function getContractorBillList($intno = 0, $showall = 'N')
    {
        $param = [
            'aedl'    => 'L',
            'intno'   => $intno,
            'showall' => $showall,
        ];

        return $this->api->get('contractor_bill.php', $param);
    }

    public function putContractorBill($intno, $data)
    {
        $aedl = $intno == 0 ? 'A' : 'E';

        $param = [
            'aedl'               => $aedl,
            'intno'              => $intno,
            'companycd'          => $data['companycd'] ?? 1,
            'bill_date'          => $data['bill_date'] ?? '',
            'contractorcd'       => $data['contractorcd'] ?? '',
            'gross_amount'       => $data['gross_amount'] ?? 0,
            'advance_adjustment' => $data['advance_adjustment'] ?? 0,
            'approval_status'    => $data['approval_status'] ?? 'PENDING',
            'approved_by'        => $data['approved_by'] ?? '',
            'approved_at'        => $data['approved_at'] ?? '',
        ];

        return $this->api->get('contractor_bill.php', $param);
    }

    public function contractorBillStat($intno, $actyn)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'  => $aedl,
            'intno' => $intno,
        ];

        return $this->api->get('contractor_bill.php', $param);
    }

    public function approveContractorBill($intno, $approved_by)
    {
        $param = [
            'aedl'        => 'APPROVE',
            'intno'       => $intno,
            'approved_by' => $approved_by,
        ];

        return $this->api->get('contractor_bill.php', $param);
    }
}