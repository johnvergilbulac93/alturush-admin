<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TomsTagRider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiderController extends Controller
{
    public function riders(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('toms_riders_data')->orderBy('toms_riders_data.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('toms_riders_data.r_firstname', 'like', '%' . $searchValue . '%')
                    ->orWhere('toms_riders_data.r_lastname', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function rider_incomplete_liabilities(Request $request)
    {
        return TomsTagRider::join('tickets', 'tickets.id', 'toms_tag_riders.ticket_id')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'toms_tag_riders.ticket_id')
            ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
            ->join('towns', 'towns.town_id', 'barangays.town_id')
            ->join('province', 'province.prov_id', 'towns.prov_id')
            ->where('toms_tag_riders.rider_id', $request->rider_id)
            ->where('toms_tag_riders.complete_status', false)
            ->where('toms_tag_riders.remitted_status', false)
            ->select('toms_tag_riders.id as tag_id', 'toms_tag_riders.*', 'tickets.*', 'customer_delivery_infos.*', 'barangays.*', 'towns.*', 'province.*')
            ->get();
    }
    public function clear_data(Request $request)
    {
        $res_param = 0;
        $res_param += TomsTagRider::where(['rider_id' => $request->rider_id, 'complete_status' => false])->whereDate('created_at', '!=', date('Y-m-d'))->update(['complete_status' => true, 'completed_at' => date('Y-m-d H:i:s'), 'admin_id' => Auth::user()->id]);
        $res_param += TomsTagRider::where(['rider_id' => $request->rider_id, 'remitted_status' => false])->whereDate('created_at', '!=', date('Y-m-d'))->update(['remitted_status' => true, 'remitted_at' => date('Y-m-d H:i:s'), 'admin_id' => Auth::user()->id]);
        if ($res_param) {
            return ['msg' => 'Rider Transaction(s) are/is successfully cleared', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => "There's no data to be clear.", 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
