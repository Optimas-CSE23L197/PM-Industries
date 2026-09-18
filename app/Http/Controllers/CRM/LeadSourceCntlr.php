<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\LeadSourceService;

class LeadSourceCntlr extends Controller
{
    public function leadSource(LeadSourceService $ls)
    {
        $leadSources = $ls->getLeadSourceList(0, session('compCdC') ?? 1, 'Y');
        $leadSources = $leadSources['data'] ?? [];

        return view('crm.masters.lead_source.index', compact('leadSources'));
    }

    public function leadSourceDetails(LeadSourceService $ls, $vwedt = null, $code = null)
    {
        $leadSource = [];
        if ($code) {
            $leadSource = $ls->getLeadSourceList($code, session('compCdC') ?? 1, 'N');
            $leadSource = $leadSource['data'][0] ?? [];
        }

        return view('crm.masters.lead_source.form', compact('leadSource', 'vwedt'));
    }

    public function saveLeadSource(Request $request, LeadSourceService $ls)
    {
        $code = $request->input('code', 0);
        $name = $request->input('name');

        $resp = $ls->putLeadSource(session('compCdC') ?? 1, $code, $name);

        return response()->json($resp);
    }

    public function statLeadSource(LeadSourceService $ls, $code, $actyn)
    {
        $res = $ls->leadSourceStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('leadSource')->with('success', $res['message']);
        else
            return redirect()->Route('leadSource')->with('error', $res['message']);
    }

    public function printLeadSourceList(LeadSourceService $ls)
    {
        $leadSources = $ls->getLeadSourceList(0, session('compCdC') ?? 1, 'Y');
        $leadSources = $leadSources['data'] ?? [];

        return view('crm.masters.lead_source.print', compact('leadSources'));
    }
}