<?php

namespace App\Http\Controllers\Masterfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\gc_minimum_order_delivery;
use App\MinOrder;
use Illuminate\Support\Facades\DB;

class MinOrderController extends Controller
{
    public function save_min_order_goods(Request $request)
    {
        $this->validate($request, [
            'store'         => 'required',
            'department'    => 'required',
            'amount' => 'required|numeric|gt:0',
        ], [
            'amount.gt' => 'The amount must not 0.'
        ]);

        $checking_data =  gc_minimum_order_delivery::where('bunit_code', $request->store)
            ->where('department_id',     $request->department)
            ->exists();

        if (!$checking_data) {
            $save = gc_minimum_order_delivery::create([
                'bunit_code'    => $request->store,
                'department_id' => $request->department,
                'amount'        => floatval($request->amount),
                'status'        => true
            ]);
            if ($save) {
                return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
            } else {
                return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    }
    public function show_min_order_goods(Request $request)
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
                'gc_minimum_order_deliveries.amount',
                'gc_minimum_order_deliveries.status as status'
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
    public function update_min_order_goods(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'store'         => 'required',
            'department'    => 'required',
            'amount'        => 'required',
        ]);
        $save =  gc_minimum_order_delivery::where('min_id', $id)->update([
            'bunit_code'    => $request->store,
            'department_id' => $request->department,
            'amount'        => floatval($request->amount)
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function status_min_order_goods(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save =  gc_minimum_order_delivery::where('min_id', $request->id)->update([
            'status'    => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function show_min_order_foods(Request $request)
    {

        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        // $query =  MinOrder::with(['tenant'])->orderBy('tenant_id', $dir);
        $query = DB::table('tbl_min_orders')
            ->join('locate_tenants', 'tbl_min_orders.tenant_id', 'locate_tenants.tenant_id')
            ->join('locate_business_units', 'locate_tenants.bunit_code', 'locate_business_units.bunit_code')
            ->select(
                'tbl_min_orders.id as id',
                'tbl_min_orders.min_order_amt as min_order_amt',
                'tbl_min_orders.status as status',
                'locate_tenants.tenant as tenant_name',
                'locate_tenants.tenant_id as tenant_id',
                'locate_business_units.bunit_code as bunit_code',
                'locate_business_units.business_unit as business_unit',
            )
            ->orderBy('tbl_min_orders.id', $dir);
        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_tenants.tenant', 'like', '%' . $searchValue . '%')
                    ->orWhere('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }
        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function save_min_order_foods(Request $request)
    {
        $this->validate($request, [
            'store'     => 'required',
            'tenant'    => 'required',
            'amount'    => 'required|numeric|gt:0',
        ], [
            'amount.gt' => 'The amount must not 0.'
        ]);

        $checking_data =  MinOrder::where('tenant_id', $request->tenant)->exists();

        if (!$checking_data) {
            $save =  MinOrder::create([
                'tenant_id'     => $request->tenant,
                'min_order_amt' => floatval($request->amount),
                'status'        => true
            ]);
            if ($save) {
                return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
            } else {
                return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
        } else {
            return response()->json([
                'errors' => ['message' => ['Tenant already been setup.! Please check to continue.']],
            ], 409);
        }
    }
    public function update_min_order_foods(Request $request)
    {
        $this->validate($request, [
            'store'         => 'required',
            'tenant'        => 'required',
            'amount'        => 'required',
        ]);
        $save =  MinOrder::whereId($request->id)->update([
            'tenant_id'        => $request->tenant,
            'min_order_amt'    => floatval($request->amount)
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function status_min_order_foods(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save =  MinOrder::whereId($request->id)->update([
            'status'    => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
