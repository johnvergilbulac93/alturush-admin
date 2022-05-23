<?php

namespace App\Http\Controllers\Masterfile;

use App\gc_bunit_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PriceGroupController extends Controller
{
    public function show_price_goup(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('locate_business_units')
            ->join('gc_price_groups', 'locate_business_units.price_group_code', 'gc_price_groups.price_group_code')
            ->select(
                'locate_business_units.bunit_code',
                'locate_business_units.business_unit',
                'locate_business_units.price_group_code',
                'gc_price_groups.price_group_name',
                'gc_price_groups.id'

            )
            ->orderBy('locate_business_units.bunit_code', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_price_groups.price_group_name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function update_price_group(Request $request)
    {
        $this->validate($request, [
            'store'             => ['required'],
            'price_group'       => ['required'],
        ]);

        $save =  gc_bunit_code::where('bunit_code', $request->store)->update([
            'price_group_code'      => $request->price_group,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
