<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BrgyController extends Controller
{
    public function show_brgy(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('barangays')
            ->join('towns', 'barangays.town_id', 'towns.town_id')
            ->join('province', 'towns.prov_id', 'province.prov_id')
            ->select(
                'barangays.brgy_id',
                'barangays.brgy_name',
                'barangays.status',
                'towns.town_id',
                'towns.town_name',
                'province.prov_id',
                'province.prov_name'
            )
            ->orderBy('barangays.brgy_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('towns.town_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('barangays.brgy_name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function update_brgy(Request $request)
    {
        $this->validate($request, [
            'province'          => ['required'],
            'town'              => ['required'],
            'barangay'          => ['required'],
        ], [
            'province.required' => 'Please select a province',
            'town.required'     => 'Please select a town',
            'barangay.required' => 'Barangay must not empty.',
            'barangay.unique'   => 'Barangay name is already exists',
        ]);
        $save = DB::table('barangays')->where('barangays.brgy_id', $request->id)->update([
            'town_id'   => $request->town,
            'brgy_name' => $request->barangay,
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function save_brgy(Request $request)
    {
        $this->validate($request, [
            'province'          => ['required'],
            'town'              => ['required'],
            'barangay'          => ['required', 'unique:barangays,brgy_name'],
        ], [
            'province.required' => 'Please select a province',
            'town.required'     => 'Please select a town',
            'barangay.required' => 'Barangay must not empty.',
            'barangay.unique'   => 'Barangay name is already exists',
        ]);
        $save = DB::table('barangays')->insert([
            'town_id'   => $request->town,
            'brgy_name' => $request->barangay,
            'status'    => 1
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
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
        $save = DB::table('barangays')->where('barangays.brgy_id', $request->id)->update([
            'status'    => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
