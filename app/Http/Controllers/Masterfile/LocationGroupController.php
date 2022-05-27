<?php

namespace App\Http\Controllers\Masterfile;

use App\BunitGroup;
use App\FDeliveryCharge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationGroupController extends Controller
{
    public function location_group()
    {
        $towns = array();
        $query = FDeliveryCharge::leftJoin('bunit_groups', 'bunit_groups.id', 'tbl_delivery_charges.bunit_group_id')
            ->leftJoin('towns', 'towns.town_id', 'tbl_delivery_charges.town_id')
            ->leftJoin('province', 'towns.prov_id', 'province.prov_id')
            ->where('tbl_delivery_charges.status', true)
            ->orderBy('town_name', 'DESC')
            ->get()
            ->groupBy('town_id');
        foreach ($query as $town) {
            $towns[]  = ['town_id' => $town->first()->town_id, 'town_name' =>  $town->first()->town_name, 'bunit_group_id' => $town->first()->bunit_group_id, 'bunit_group' => $town->first()->bunit_group];
        }
        return $towns;
    }
    public function get_default_data()
    {
        $towns = array();
        $town_list = FDeliveryCharge::join('towns', 'towns.town_id', 'tbl_delivery_charges.town_id')
            ->join('province', 'towns.prov_id', 'province.prov_id')->where('tbl_delivery_charges.status', true)->orderBy('town_name')->get()->groupBy('town_id');
        foreach ($town_list as $town) {
            $towns[]  = ['town_id' => $town->first()->town_id, 'town_name' =>  $town->first()->town_name];
        }
        $bu_group = BunitGroup::where('status', true)->get();
        return response()->json(['towns' => $towns, 'bu_group' => $bu_group]);
    }
    public function update_data(Request $request)
    {
        $this->validate($request, [
            'town'      => ['required'],
            'group'              => ['required'],

        ], [
            'town.required' => 'Please select a town.',
            'group.required'   => 'Please select a group.'
        ]);
        $save = FDeliveryCharge::where(['town_id' => $request->town])->update(['bunit_group_id' => $request->group]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
