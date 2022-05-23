<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TownController extends Controller
{
    public function show_town(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('towns')
            ->join('province', 'towns.prov_id', 'province.prov_id')
            ->select(
                'towns.town_id',
                'towns.town_name',
                'towns.zipcode',
                'towns.status',
                'towns.prov_id',
                'province.prov_name'
            )
            ->orderBy('towns.town_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('towns.town_name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function save_town(Request $request)
    {
        $this->validate($request, [
            'province'      => ['required'],
            'town'          => ['required', 'unique:towns,town_name'],
            'zipcode'       => ['required', 'unique:towns,zipcode'],
        ], [
            'town.unique'       => 'Town has already exist.',
            'zipcode.unique'    => 'Zipcode has already exist.'
        ]);
        $save  =  DB::table('towns')->insert([
            'town_name' => $request->town,
            'prov_id'   => $request->province,
            'zipcode'   => $request->zipcode
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_town(Request $request)
    {
        $this->validate($request, [
            'town'          => ['required'],
            'province'      => ['required'],
            'zipcode'       => ['required'],
        ]);
        $save = DB::table('towns')->where('towns.town_id', $request->id)->update([
            'town_name' => $request->town,
            'zipcode'   => $request->zipcode,
            'prov_id'   => $request->province
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
        $save  = DB::table('towns')->where('towns.town_id', $request->id)->update([
            'status'    => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
