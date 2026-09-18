<?php
namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Production\FinishedItemTypeService;

class FinishedItemTypeCntlr extends Controller
{
    public function finishedItemType(FinishedItemTypeService $fits)
    {
        $finishedItemTypes = $fits->getFinishedItemTypeList(0, session('compCdC') ?? 1, 'Y');
        $finishedItemTypes = $finishedItemTypes['data'] ?? [];

        return view('productions.masters.finished_item_type.index', compact('finishedItemTypes'));
    }

    public function finishedItemTypeDetails(FinishedItemTypeService $fits, $vwedt = null, $code = null)
    {
        $finishedItemType = [];
        if ($code) {
            $finishedItemType = $fits->getFinishedItemTypeList($code, session('compCdC') ?? 1, 'N');
            $finishedItemType = $finishedItemType['data'][0] ?? [];
        }

        return view('productions.masters.finished_item_type.form', compact('finishedItemType', 'vwedt'));
    }

    public function saveFinishedItemType(Request $request, FinishedItemTypeService $fits)
    {
        $code = $request->input('code', 0);
        $name = $request->input('name');

        $resp = $fits->putFinishedItemType(session('compCdC') ?? 1, $code, $name);

        return response()->json($resp);
    }

    public function statFinishedItemType(FinishedItemTypeService $fits, $code, $actyn)
    {
        $res = $fits->finishedItemTypeStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('finishedItemType')->with('success', $res['message']);
        else
            return redirect()->Route('finishedItemType')->with('error', $res['message']);
    }

    public function printFinishedItemTypeList(FinishedItemTypeService $fits)
    {
        $finishedItemTypes = $fits->getFinishedItemTypeList(0, session('compCdC') ?? 1, 'Y');
        $finishedItemTypes = $finishedItemTypes['data'] ?? [];

        return view('productions.masters.finished_item_type.print', compact('finishedItemTypes'));
    }
}