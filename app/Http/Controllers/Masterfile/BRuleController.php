<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use App\gc_setup_business_rule;
use App\Http\Controllers\Controller;

class BRuleController extends Controller
{
    public function show_rule()
    {
        return gc_setup_business_rule::all();
    }
    public function update_rule(Request $request)
    {
        $save =  gc_setup_business_rule::whereId($request->id)->update([
            'minimum_order_amount'          => $request->min_order_amt,
            'pickup_charge'                 => $request->pickup_charge,
            'ordering_cutoff_time_start'    => $request->order_cutoff_start,
            'ordering_cutoff_time_end'      => $request->order_cutoff_end,
            'serving_time_start'            => $request->serving_time_start,
            'serving_time_end'              => $request->serving_time_end,
            'maximum_no_of_orders'          => $request->max_no_order,
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
