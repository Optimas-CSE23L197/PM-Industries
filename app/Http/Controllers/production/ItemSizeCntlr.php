<?php
namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Production\ItemSizeService;

class ItemSizeCntlr extends Controller
{
    public function itemSize(ItemSizeService $iss)
    {
        $itemSizes = $iss->getItemSizeList(0, session('compCdC') ?? 1, 'Y');
        $itemSizes = $itemSizes['data'] ?? [];

        return view('productions.masters.item_size.index', compact('itemSizes'));
    }

    public function itemSizeDetails(ItemSizeService $iss, $vwedt = null, $code = null)
    {
        $itemSize = [];
        if ($code) {
            $itemSize = $iss->getItemSizeList($code, session('compCdC') ?? 1, 'N');
            $itemSize = $itemSize['data'][0] ?? [];
        }

        return view('productions.masters.item_size.form', compact('itemSize', 'vwedt'));
    }

    public function saveItemSize(Request $request, ItemSizeService $iss)
    {
        $code = $request->input('code', 0);
        $name = $request->input('name');

        $resp = $iss->putItemSize(session('compCdC') ?? 1, $code, $name);

        return response()->json($resp);
    }

    public function statItemSize(ItemSizeService $iss, $code, $actyn)
    {
        $res = $iss->itemSizeStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('itemSize')->with('success', $res['message']);
        else
            return redirect()->Route('itemSize')->with('error', $res['message']);
    }

    public function printItemSizeList(ItemSizeService $iss)
    {
        $itemSizes = $iss->getItemSizeList(0, session('compCdC') ?? 1, 'Y');
        $itemSizes = $itemSizes['data'] ?? [];

        return view('productions.masters.item_size.print', compact('itemSizes'));
    }
}