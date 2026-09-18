<?php
namespace App\Services\RawMaterialsInventory;
use App\Services\ApiClient;

class Issue_ReturnService{
    protected $api;

    public function __construct (ApiClient $api){
        $this->api = $api;
    }

    public function getList( $intno, $ir, $showall){
        $param = [
                    'aedl' => 'L',
                    'ir'=> $ir,
                    'showall' => $showall
                 ];
        if($intno)
            $param['intno'] = $intno;
        return $this->api->get('issue_return.php', $param);
    }

    public function saveIssueRtn( $usercd, $ir, array $payload ){
        $aedl = $payload['intno'] ? 'E' : 'A';
        $param = [
                    'aedl' => $aedl,
                    'intno' => $payload['intno'] ?? '',
                    'ir' => $ir,
                    'issue_no' => $payload['issue_no'] ??'',
                    'issue_date' => $payload['issue_date'] ??'',
                    'fromdeptcd' => $payload['fromdeptcd'] ??'',
                    'todeptcd' => $payload['todeptcd'] ??'',
                    'usercd' => $usercd,
                    'items' => $payload['items'] ?? [],
                    'activeyn' => $payload['activeyn'] ?? 'Y'
                 ];
        // dd( $param );
        return $this->api->get('issue_return.php', $param);
    }

    public function statIssueRtn( $intno, $aedl, $ir ){
        $param = [
                    'aedl' => $aedl,
                    'intno' => $intno,
                    'ir' => $ir
                 ];
        return $this->api->get('issue_return.php', $param);
    }
}