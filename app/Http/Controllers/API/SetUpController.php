<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\gc_minimum_order_delivery;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\TenantFood;

class SetUpController extends Controller
{

    public function create_minimum(Request $request)
    {
        $this->validate($request, [
            'store'         => 'required',
            'department'    => 'required',
            'amount'        => 'required',
        ]);

        $checking_data =  gc_minimum_order_delivery::where('bunit_code', $request->store)
            ->where('department_id',     $request->department)
            ->exists();

        if (!$checking_data) {

            gc_minimum_order_delivery::create([
                'bunit_code'    => $request->store,
                'department_id' => $request->department,
                'amount'        => floatval($request->amount)
            ]);
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    }
    public function show_min_order(Request $request)
    {

        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query =  DB::table('gc_minimum_order_deliveries')
            ->join('locate_business_units', 'gc_minimum_order_deliveries.bunit_code', '=', 'locate_business_units.bunit_code')
            ->join('gc_departments', 'gc_minimum_order_deliveries.department_id', '=', 'gc_departments.dept_id')
            ->select(
                'gc_minimum_order_deliveries.min_id',
                'locate_business_units.business_unit',
                'gc_departments.name',
                'gc_minimum_order_deliveries.bunit_code',
                'gc_minimum_order_deliveries.department_id',
                'gc_minimum_order_deliveries.amount'
            )
            ->orderBy('gc_minimum_order_deliveries.min_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;

        return $query;
    }
    public function edit_minimum(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'store'         => 'required',
            'department'    => 'required',
            'amount'        => 'required',
        ]);
        gc_minimum_order_delivery::where('min_id', $id)->update([
            'bunit_code'    => $request->store,
            'department_id' => $request->department,
            'amount'        => floatval($request->amount)
        ]);
    }
    public function delete_minimum($id)
    {
        gc_minimum_order_delivery::where('min_id', $id)->delete();
    }

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
