<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\gc_minimum_order_delivery;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\TenantFood;

class SetUpController extends Controller
{
    public function delete_price_group($id)
    {
        DB::table('locate_business_units')->where('locate_business_units.bunit_code', $id)->update([
            'active' => 0
        ]);
    }

    public function show_tenant_food(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = TenantFood::with(['businessunit', 'GlobalCategory', 'contact_nums'])->orderBy('tenant_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('tenant', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
}
