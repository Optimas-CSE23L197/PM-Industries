<?php
namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Production\FinishedItemService;

class FinishedItemCntlr extends Controller
{
    public function finishedItem(FinishedItemService $fis)
    {
        $finishedItems = $fis->getFinishedItemList(0, session('compCdC') ?? 1, 'Y');
        $finishedItems = $finishedItems['data'] ?? [];

        return view('productions.masters.finished_item.index', compact('finishedItems'));
    }

    public function finishedItemDetails(FinishedItemService $fis, $vwedt = null, $code = null)
    {
        $finishedItem = '';
        if ($code) {
            $finishedItem = $fis->getFinishedItemList($code, session('compCdC') ?? 1, 'N');
            $finishedItem = $finishedItem['data'][0] ?? [];
        }

        return view('productions.masters.finished_item.form', compact('finishedItem', 'vwedt'));
    }

    public function saveFinishedItem(Request $request, FinishedItemService $fis)
    {
        $code          = $request->input('code', 0);
        $name          = $request->input('name');
        $unit          = $request->input('unit');
        $standard_cost = $request->input('standard_cost');

        $resp = $fis->putFinishedItem(session('compCdC') ?? 1, $code, $name, $unit, $standard_cost);

        return response()->json($resp);
    }

    public function statFinishedItem(FinishedItemService $fis, $code, $actyn)
    {
        $res = $fis->finishedItemStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('finishedItem')->with('success', $res['message']);
        else
            return redirect()->Route('finishedItem')->with('error', $res['message']);
    }
}