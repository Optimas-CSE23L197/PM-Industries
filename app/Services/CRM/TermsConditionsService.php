<?php
namespace App\Services\Crm;

use App\Services\ApiClient;

class TermsConditionsService
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /**
     * Fetch T&C list (all rows for company)
     * Optional filter by qid (Q/I/D)
     */
    public function getTermsConditionsList($compcd, $qid = null, $showall = 'Y')
    {
        $param = [
            'aedl'    => 'L',
            'compcd'  => $compcd,
            'showall' => $showall
        ];

        if ($qid) {
            $param['qid'] = $qid;
        }

        return $this->api->get('termnconditions.php', $param);
    }

    /**
     * Fetch single T&C by code
     */
    public function getTermsConditions($code, $compcd)
    {
        $param = [
            'aedl'   => 'L',
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('termnconditions.php', $param);
    }

    /**
     * Add/Edit T&C
     * $qid = Q / I / D
     * $term_text = actual text
     */
    public function putTermsConditions($compcd, $code, $qid, $term_text)
    {
        $aedl = $code == 0 ? 'A' : 'E';

        $param = [
            'aedl'      => $aedl,
            'compcd'    => $compcd,
            'code'      => $code,
            'qid'       => $qid,
            'term_text' => $term_text,
            'activeyn'  => 'Y'
        ];

        return $this->api->get('termnconditions.php', $param);
    }

    public function termsConditionsStat($code, $actyn, $compcd)
    {
        $aedl = $actyn == 'Y' ? 'D' : 'U';

        $param = [
            'aedl'   => $aedl,
            'code'   => $code,
            'compcd' => $compcd
        ];

        return $this->api->get('termnconditions.php', $param);
    }
}