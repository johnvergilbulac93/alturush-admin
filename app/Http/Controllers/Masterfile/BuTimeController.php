<?php

namespace App\Http\Controllers\Masterfile;

use App\Bu_time_setup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BuTimeController extends Controller
{
    public function show_bunit_time(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('bu_time_setups')
            ->join('locate_business_units', 'bu_time_setups.bunit_code', '=', 'locate_business_units.bunit_code')
            ->select(
                'bu_time_setups.id',
                'locate_business_units.bunit_code',
                'locate_business_units.business_unit',
                'locate_business_units.acroname',
                'bu_time_setups.time_in',
                'bu_time_setups.time_out',
                'bu_time_setups.status',
            )
            ->orderBy('bu_time_setups.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function save_business_time(Request $request)
    {
        $this->validate($request, [
            'store'        => ['required', 'unique:bu_time_setups,bunit_code'],
            'opening'      => ['required'],
            'closing'      => ['required', 'after:opening_time'],
        ], [
            'store.unique'     => 'The store is already been added',
            'opening.required' => 'The opening time field is required.',
            'closing.required' => 'The closing time field is required.'
        ]);

        $save =  Bu_time_setup::create([
            'bunit_code'    => $request->store,
            'time_in'       => $request->opening_time,
            'time_out'      => $request->closing_time,
            'status'        => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_business_time(Request $request)
    {
        $this->validate($request, [
            'store'        => ['required'],
            'opening'      => ['required'],
            'closing'      => ['required', 'after:opening_time'],
        ], [
            'opening.required' => 'The opening time field is required.',
            'closing.required' => 'The closing time field is required.'
        ]);
        $save =  Bu_time_setup::whereId($request->id)->update([
            'bunit_code'    => $request->store,
            'time_in'       => $request->opening,
            'time_out'      => $request->closing,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_status(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save = Bu_time_setup::whereId($request->id)->update([
            'status'                => $status,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
