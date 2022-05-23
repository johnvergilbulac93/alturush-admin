<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    public function not_available_item()
    {
        return DB::table('gc_item_log_availables')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'store')
            ->select('locate_business_units.business_unit', DB::raw('COUNT(store) as store'))
            ->groupBy('store')
            ->get();
    }
    public function top_items(Request $request)
    {

        $year = Carbon::parse($request->year)->format('Y');
        $month = Carbon::parse($request->month)->format('m');
        $perYear = $request->flag;

        $query1 = DB::table('gc_final_order')
            ->join('gc_product_items', 'gc_product_items.product_id', '=', 'gc_final_order.product_id')
            ->join('gc_product_prices', 'gc_product_prices.price_id', '=', 'gc_final_order.product_id')
            ->where('canceled_status', 0)
            ->whereMonth('created_at', intval($month))
            ->whereYear('gc_final_order.created_at', $year)
            ->select(
                'gc_product_items.product_name',
                'gc_product_items.category_group',
                'gc_product_items.category_name',
                'gc_product_items.product_id',
                'gc_product_prices.UOM',
                'gc_final_order.uom_id',
                'gc_final_order.created_at',
                DB::raw('SUM(gc_final_order.quantity) as sales'),
                // DB::raw("DATE_FORMAT(gc_final_order.created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(gc_final_order.created_at) year, MONTH(gc_final_order.created_at) month')

            )
            ->groupBy('product_id')
            ->groupBy('uom_id')

            ->orderBy('sales', 'DESC')
            ->take(10)
            ->get();

        $query2 = DB::table('gc_final_order')
            ->join('gc_product_items', 'gc_product_items.product_id', '=', 'gc_final_order.product_id')
            ->join('gc_product_prices', 'gc_product_prices.price_id', '=', 'gc_final_order.product_id')
            ->where('canceled_status', 0)
            ->whereYear('gc_final_order.created_at', $year)
            ->select(
                'gc_product_items.product_name',
                'gc_product_items.category_group',
                'gc_product_items.category_name',
                'gc_product_items.product_id',
                'gc_product_prices.UOM',
                'gc_final_order.uom_id',
                'gc_final_order.created_at',
                DB::raw('SUM(gc_final_order.quantity) as sales'),
                // DB::raw("DATE_FORMAT(gc_final_order.created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(gc_final_order.created_at) year, MONTH(gc_final_order.created_at) month')

            )
            ->groupBy('product_id')
            ->groupBy('uom_id')

            ->orderBy('sales', 'DESC')
            ->take(10)
            ->get();

        if ($perYear === "true") {
            return $query2;
        }
        if ($perYear === "false") {
            return $query1;
        }
    }

    public function top_item_store(Request $request)
    {

        dd('Hellow');
    }
}
