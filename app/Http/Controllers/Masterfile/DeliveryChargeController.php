<?php

namespace App\Http\Controllers\Masterfile;

use App\FDeliveryCharge;
use App\gc_delivery_charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryChargeController extends Controller
{
    public function show_delivery_charges_goods(Request $request)
    {
        $length     = $request->length;
        $dir        = $request->dir;
        $searchValue     = $request->search;

        $query = gc_delivery_charge::with(['brgy'])
            ->join('province', 'gc_delivery_charges.prov_id', '=', 'province.prov_id')
            ->join('towns', 'gc_delivery_charges.town_id', '=', 'towns.town_id')
            ->join('gc_transportations', 'gc_delivery_charges.transpo_id', '=', 'gc_transportations.id')
            ->select(
                'gc_delivery_charges.chrg_id',
                'gc_delivery_charges.prov_id',
                'gc_delivery_charges.town_id',
                'gc_delivery_charges.brgy_id',
                'gc_delivery_charges.transpo_id',
                'gc_delivery_charges.charge_amt',
                'gc_delivery_charges.rider_shared',
                'gc_delivery_charges.status',
                'province.prov_name',
                'towns.town_name',
                'gc_transportations.transpo_name',
            )
            ->orderBy('gc_delivery_charges.chrg_id', $dir);
        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('province.prov_name',  'like', '%' . $searchValue . '%')
                    ->orWhere('towns.town_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_transportations.transpo_name', 'like', '%' . $searchValue . '%');
            });
        }
        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_delivery_charges_goods(Request $request)
    {
        $this->validate($request, [
            'province'              => 'required',
            'town'                  => 'required',
            'transportation'        => 'required',
            'charge_amount'         => 'required',
            'rider_share'           => 'required',
        ], [
            'province.required'             => 'Please select a province.',
            'town.required'                 => 'Please select a town.',
            'transportation.required'       => 'Please select a vehicle type.',
            'charge_amount.required'        => 'Please enter a delivery charge amount.',
            'rider_share.required'          => 'Please enter a convenience fee amount.',
        ]);

        if ($request->barangay) {
            $checking_data =  gc_delivery_charge::where('town_id', $request->town)
                ->where('brgy_id',     $request->barangay)
                ->where('transpo_id',  $request->transportation)
                ->exists();
        } else {
            $checking_data =  gc_delivery_charge::where('town_id', $request->town)
                ->where('transpo_id',  $request->transportation)
                ->exists();
        }
        if (!$checking_data) {
            $save = gc_delivery_charge::create([
                'prov_id'           => $request->province,
                'town_id'           => $request->town,
                'brgy_id'           => $request->barangay,
                'transpo_id'        => $request->transportation,
                'charge_amt'        => $request->charge_amount,
                'rider_shared'      => $request->rider_share,
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
    public function update_delivery_charges_goods(Request $request)
    {
        $this->validate($request, [
            'province'          => 'required',
            'town'              => 'required',
            'transportation'    => 'required',
            'charge_amount'     => 'required',
            'rider_share'       => 'required',
        ], [
            'province.required'             => 'Please select a province.',
            'town.required'                 => 'Please select a town.',
            'transportation.required'       => 'Please select a vehicle type.',
            'charge_amount.required'        => 'Please enter a delivery charge amount.',
            'rider_share.required'          => 'Please enter a convenience fee amount.',
        ]);

        $save =  gc_delivery_charge::where('chrg_id', $request->id)->update([
            'prov_id'           => $request->province,
            'town_id'           => $request->town,
            'brgy_id'           => $request->barangay,
            'transpo_id'        => $request->transportation,
            'charge_amt'        => floatval($request->charge_amount),
            'rider_shared'      => floatval($request->rider_share),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_status_goods(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save = gc_delivery_charge::where('chrg_id', $request->id)->update([
            'status'                 => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function show_delivery_charges_foods(Request $request)
    {

        $length     = $request->length;
        $dir        = $request->dir;
        $searchValue     = $request->search;

        $query = FDeliveryCharge::with(['barangay'])
            ->join('towns', 'tbl_delivery_charges.town_id', '=', 'towns.town_id')
            ->join('province', 'towns.prov_id', '=', 'province.prov_id')
            ->join('gc_transportations', 'tbl_delivery_charges.vtype', '=', 'gc_transportations.id')
            ->join('fd_location_ranges', 'tbl_delivery_charges.range_id', '=', 'fd_location_ranges.id')
            ->select(
                '*',
                'tbl_delivery_charges.id as charg_id',
                'tbl_delivery_charges.town_id as town_id',
                'tbl_delivery_charges.brgy_id as brgy_id',
                'tbl_delivery_charges.range_id as range_id',
                'tbl_delivery_charges.vtype as vtype_id',
                'tbl_delivery_charges.charge_amt',
                'tbl_delivery_charges.customer_to_pay',
                'tbl_delivery_charges.fuel_amt',
                'tbl_delivery_charges.rider_share',
                'tbl_delivery_charges.admin_fee',
                'tbl_delivery_charges.expenses_for_store',
                'tbl_delivery_charges.status as chrg_status',
                'fd_location_ranges.range_level',
                'gc_transportations.transpo_name',
                'province.prov_name as province',
                'towns.town_name',

            )
            ->orderBy('charg_id', $dir);
        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('towns.town_name',  'like', '%' . $searchValue . '%')
                    ->orWhere('gc_transportations.transpo_name', 'like', '%' . $searchValue . '%');
            });
        }
        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_delivery_charges_foods(Request $request)
    {
        $this->validate($request, [
            'province'              => 'required',
            'town'                  => 'required',
            'delivery_charge'       => 'required|numeric|not_in:0',
            'customer_to_pay'       => 'required',
            'fuel'                  => 'required',
            'rider_share'           => 'required',
            'admin_fee'             => 'required',
            'expense_for_store'     => 'required',
            'range_level'           => 'required',
            'transportation'        => 'required',


        ], [
            'province.required'             => 'Please select a province.',
            'town.required'                 => 'Please select a town.',
            'delivery_charge.required'      => 'Please input a delivery charge amount.',
            'customer_to_pay.required'      => 'Please input a customer to pay amount.',
            'fuel.required'                 => 'Please inout a fuel  amount.',
            'rider_share.required'          => 'Please input a rider share  amount.',
            'admin_fee.required'            => 'Please input a admin fee amount.',
            'expense_for_store.required'    => 'Please input a expenses for store  amount.',
            'range_level.required'          => 'Please select a range level.',
            'transportation.required'       => 'Please select a vehicle type.',

        ]);

        if ($request->barangay) {
            $checking_data =  FDeliveryCharge::where('town_id', $request->town)
                ->where('brgy_id',     $request->barangay)
                ->where('vtype',  $request->transportation)
                ->exists();
        } else {
            $checking_data =  FDeliveryCharge::where('town_id', $request->town)
                ->where('vtype',  $request->transportation)
                ->exists();
        }
        if (!$checking_data) {
            $save = FDeliveryCharge::create([
                'town_id'               => $request->town,
                'brgy_id'               => $request->barangay,
                'charge_amt'            => $request->delivery_charge,
                'customer_to_pay'       => $request->customer_to_pay,
                'fuel_amt'              => $request->fuel,
                'rider_share'           => $request->rider_share,
                'admin_fee'             => $request->admin_fee,
                'expenses_for_store'    => $request->expense_for_store,
                'range_id'              => $request->range_level,
                'vtype'                 => $request->transportation,
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
    public function update_delivery_charges_foods(Request $request)
    {
        $this->validate($request, [
            'province'              => 'required',
            'town'                  => 'required',
            'delivery_charge'       => 'required|numeric|not_in:0',
            'customer_to_pay'       => 'required',
            'fuel'                  => 'required',
            'rider_share'           => 'required',
            'admin_fee'             => 'required',
            'expense_for_store'     => 'required',
            'range_level'           => 'required',
            'transportation'        => 'required',


        ], [
            'province.required'             => 'Please select a province.',
            'town.required'                 => 'Please select a town.',
            'delivery_charge.required'      => 'Please input a delivery charge amount.',
            'customer_to_pay.required'      => 'Please input a customer to pay amount.',
            'fuel.required'                 => 'Please inout a fuel  amount.',
            'rider_share.required'          => 'Please input a rider share  amount.',
            'admin_fee.required'            => 'Please input a admin fee amount.',
            'expense_for_store.required'    => 'Please input a expenses for store  amount.',
            'range_level.required'          => 'Please select a range level.',
            'transportation.required'       => 'Please select a vehicle type.',

        ]);
        $save = FDeliveryCharge::whereId($request->id)->update([
            'town_id'               => $request->town,
            'brgy_id'               => $request->barangay,
            'charge_amt'            => $request->delivery_charge,
            'customer_to_pay'       => $request->customer_to_pay,
            'fuel_amt'              => $request->fuel,
            'rider_share'           => $request->rider_share,
            'admin_fee'             => $request->admin_fee,
            'expenses_for_store'    => $request->expense_for_store,
            'range_id'              => $request->range_level,
            'vtype'                 => $request->transportation,
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_status_foods(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save = FDeliveryCharge::whereId($request->id)->update([
            'status'                 => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
