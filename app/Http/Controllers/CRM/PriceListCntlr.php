<?php
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Crm\PriceListService;
use App\Services\Production\FinishedItemService;

class PriceListCntlr extends Controller
{
    public function priceList(PriceListService $pls)
    {
        $priceLists = $pls->getPriceList(0, session('compCdC') ?? 1, 'Y');
        $priceLists = $priceLists['data'] ?? [];

        return view('crm.masters.price_list.index', compact('priceLists'));
    }

    public function priceListDetails(PriceListService $pls, FinishedItemService $fis, $vwedt = null, $code = null)
    {
        $priceList = [];
        $details   = [];

        if ($code) {
            $response = $pls->getPriceList($code, session('compCdC') ?? 1, 'N');
            $rows     = $response['data'] ?? [];

            if (!empty($rows)) {
                $first = $rows[0];
                $priceList = [
                    'code'       => $first['code'] ?? 0,
                    'name'       => $first['name'] ?? '',
                    'valid_from' => $first['valid_from'] ?? '',
                    'valid_to'   => $first['valid_to'] ?? '',
                    'activeyn'   => $first['activeyn'] ?? 'Y'
                ];

                foreach ($rows as $r) {
                    if (!empty($r['detail_code']) && !empty($r['finisheditemcd'])) {
                        $details[] = [
                            'detail_code'    => $r['detail_code'],
                            'finisheditemcd' => $r['finisheditemcd'],
                            'finisheditemnm' => $r['finished_item_name'] ?? '',
                            'rate'           => $r['rate'] ?? 0,
                            'min_qty'        => $r['min_qty'] ?? 0,
                            'activeyn'       => $r['detail_activeyn'] ?? 'Y'
                        ];
                    }
                }
            }
        }

        $finishedItems = $fis->getFinishedItemList(0, session('compCdC') ?? 1, 'Y');
        $finishedItems = $finishedItems['data'] ?? [];

        return view('crm.masters.price_list.form', compact('priceList', 'details', 'vwedt', 'finishedItems'));
    }

    public function savePriceList(Request $request, PriceListService $pls)
    {
        $code       = $request->input('code', 0);
        $name       = $request->input('name');
        $valid_from = $request->input('valid_from');
        $valid_to   = $request->input('valid_to');
        $details    = $request->input('details', '[]');

        // If details comes as array, encode it
        if (is_array($details)) {
            $details = json_encode($details);
        }

        $resp = $pls->putPriceList(session('compCdC') ?? 1, $code, $name, $valid_from, $valid_to, $details);

        return response()->json($resp);
    }

    public function statPriceList(PriceListService $pls, $code, $actyn)
    {
        $res = $pls->priceListStat($code, $actyn, session('compCdC') ?? 1);
        if(!$res['error'])
            return redirect()->Route('priceList')->with('success', $res['message']);
        else
            return redirect()->Route('priceList')->with('error', $res['message']);
    }

    public function printPriceList(PriceListService $pls)
    {
        $response = $pls->getPriceList(0, session('compCdC') ?? 1, 'Y');
        $rows     = $response['data'] ?? [];

        $priceLists = [];
        foreach ($rows as $r) {
            $code = $r['code'] ?? 0;
            if (!isset($priceLists[$code])) {
                $priceLists[$code] = [
                    'code'       => $code,
                    'name'       => $r['name'] ?? '',
                    'valid_from' => $r['valid_from'] ?? '',
                    'valid_to'   => $r['valid_to'] ?? '',
                    'activeyn'   => $r['activeyn'] ?? 'Y',
                    'details'    => []
                ];
            }

            if (!empty($r['finisheditemcd'])) {
                $priceLists[$code]['details'][] = [
                    'finisheditemnm' => $r['finished_item_name'] ?? '',
                    'rate'           => $r['rate'] ?? 0,
                    'min_qty'        => $r['min_qty'] ?? 0,
                ];
            }
        }

        $priceLists = array_values($priceLists);

        return view('crm.masters.price_list.print', compact('priceLists'));
    }
}