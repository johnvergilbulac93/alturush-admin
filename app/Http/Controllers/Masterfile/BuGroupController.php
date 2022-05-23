<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BuGroupController extends Controller
{
    public function bu_group()
    {
        return DB::table('bunit_groups')->where('status', true)->get();
    }
    public function show_bunit_group(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = DB::table('bunit_groups')->orderBy('bunit_groups.id', $dir);

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('bunit_groups.bunit_group', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_bunit_group(Request $request)
    {
        $this->validate($request, [
            'group'             => ['required'],
        ]);
        $save = DB::table('bunit_groups')->create([
            'bunit_group'           => $request->group,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_bunit_group(Request $request)
    {
        $this->validate($request, [
            'group'             => ['required'],
        ]);
        $save = DB::table('bunit_groups')->where('bunit_groups.id', $request->id)->update([
            'bunit_group'           => $request->group,
            'updated_at'            => date('Y-m-d H:i:s'),
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
        $save =  DB::table('bunit_groups')->where('bunit_groups.id', $request->id)->update([
            'status'                => $status,
            'updated_at'            => date('Y-m-d H:i:s'),
        ]);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
