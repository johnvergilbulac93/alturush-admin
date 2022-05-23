<?php

namespace App\Http\Controllers\Export;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function export_product(Request $request)
    {
        $this->validate($request, [
            'type'      => 'required',
            'store'   => 'required'
        ], [
            'type.required' => 'Choose a report type to continue.',
            'store.required' => 'Choose a store to continue.'
        ]);
        $filter = $request->type;
        $store = $request->store;
        $getBU = DB::table('locate_business_units')->where('bunit_code', $store)->first();

        if ($filter === 'all') {

            $filename = $getBU->acroname . '-ALL-ITEMS-' . Carbon::now()->format('Y-m-d-hms') . '.xls';

            $query =   DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_items.status', 'active')
                ->where('gc_product_prices.status', 1)
                ->get();
            $result['items'] = $query;
            $result['filename'] = $filename;
            return $result;
        }

        if ($filter === 'available') {

            $filename = $getBU->acroname . '-AVAILABLE-ITEMS-' . Carbon::now()->format('Y-m-d-hms') . '.xls';

            $query =   DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_items.status', 'active')
                ->where('gc_product_prices.status', 1)
                ->whereNotIn('gc_product_items.itemcode', function ($query) use ($store) {
                    $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', $store);
                })
                ->get();
            $result['items'] = $query;
            $result['filename'] = $filename;
            return $result;
        }

        if ($filter === 'unavailable') {

            $filename = $getBU->acroname . '-UNAVAILABLE-ITEMS-' . Carbon::now()->format('Y-m-d-hms') . '.xls';

            $query =  DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_prices.status', 1)
                ->whereIn('gc_product_items.itemcode', function ($query) use ($store) {
                    $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', $store);
                })->get();

            $result['items'] = $query;
            $result['filename'] = $filename;
            return $result;
        }
    }
}
