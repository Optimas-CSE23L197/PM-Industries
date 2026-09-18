<?php
namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Production\BomService;
use App\Services\Production\FinishedItemService;
use App\Services\RawMaterialsInventory\RawItemService;

class BomCntlr extends Controller
{
    public function bom(BomService $bs)
    {
        $boms = $bs->getBomList(0, session('compCdC') ?? 1, 'Y');
        $boms = $boms['data'] ?? [];

        return view('productions.masters.bom.index', compact('boms'));
    }

    public function bomDetails(BomService $bs, FinishedItemService $fis, RawItemService $ris, $vwedt = null, $code = null)
    {
        $bom = '';
        if ($code) {
            $bom = $bs->getBomList($code, session('compCdC') ?? 1, 'N');
            $bom = $bom['data'][0] ?? [];
        }

        $finishedItems = $fis->getFinishedItemList(0, session('compCdC') ?? 1, 'Y');
        $finishedItems = $finishedItems['data'] ?? [];

        $rawItems = $ris->getList(0, 'Y');
        $rawItems = $rawItems['data'] ?? [];

        return view('productions.masters.bom.form', compact('bom', 'vwedt', 'finishedItems', 'rawItems'));
    }

    public function saveBom(Request $request, BomService $bs)
    {
        $code           = $request->input('code', 0);
        $finisheditemcd = $request->input('finisheditemcd');
        $qty            = $request->input('qty');
        $userid         = session('userId') ?? 1;

        $rawDetails = $request->input('bomdtl', []);
        $parts      = [];

        foreach ($rawDetails as $row) {
            if (empty($row['rawitemcd']) || !isset($row['qty']) || $row['qty'] === '') {
                continue;
            }

            $rawitemcd = (int) $row['rawitemcd'];
            $rowQty    = (float) $row['qty'];
            $activeyn  = 'Y';

            $parts[] = $rawitemcd . '|' . $rowQty . '|' . $activeyn;
        }

        if (empty($parts)) {
            return response()->json([
                'error'   => true,
                'message' => 'Please add at least one Raw Item.'
            ]);
        }

        $bomdtl = implode('||', $parts);

        $resp = $bs->putBom(session('compCdC') ?? 1, $code, $finisheditemcd, $qty, $userid, $bomdtl);

        return response()->json($resp);
    }

    public function statBom(BomService $bs, $code, $actyn)
    {
        $res = $bs->bomStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('bom')->with('success', $res['message']);
        else
            return redirect()->Route('bom')->with('error', $res['message']);
    }

    public function printBomList(BomService $bs)
    {
        $boms = $bs->getBomList(0, session('compCdC') ?? 1, 'Y');
        $boms = $boms['data'] ?? [];

        return view('productions.masters.bom.print', compact('boms'));
    }
}