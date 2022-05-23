<?php

namespace App\Http\Controllers\Masterfile;

use App\gc_bunit_code;
use App\GlobalCatUnavailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class BunitController extends Controller
{
    public function show_business_unit(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = gc_bunit_code::with('bunitgroup')->orderBy('bunit_code', $dir);

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_business_unit(Request $request)
    {
        $this->validate($request, [
            'group'             => ['required'],
            'acroname'          => ['required'],
            'business_unit'     => ['required'],
        ], [
            'group.required'    => 'Please select a group.'
        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = 'bu_' . $request->acroname . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/business_units');
            $image->move($path, $imageName);
            if (file_exists($path . $imageName)) {
                @unlink($path . $imageName);
            }
            $picName = 'images/business_units/' . $imageName;
        } else {
            $picName = 'images/business_units/' . 'noimage.png';
        }

        $save =  DB::table('locate_business_units')->insert([
            'business_unit'          => strtoupper($request->business_unit),
            'acroname'               =>  strtoupper($request->acroname),
            'group_id'               => $request->group,
            'logo'                   => $picName,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);

        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_business_unit(Request $request)
    {
        $this->validate($request, [
            'group'             => ['required'],
            'acroname'          => ['required'],
            'business_unit'     => ['required'],
        ], [
            'group.required'    => 'Please select a group.'
        ]);
        $save =  DB::table('locate_business_units')->where('locate_business_units.bunit_code', $request->id)->update([
            'business_unit'          => strtoupper($request->business_unit),
            'acroname'               =>  strtoupper($request->acroname),
            'group_id'               => $request->group,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function status_business_unit(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save =  DB::table('locate_business_units')->where('locate_business_units.bunit_code', $request->id)->update([
            'active'                => $status,
            'updated_at'            => date('Y-m-d H:i:s'),
        ]);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function set_global_category(Request $request)
    {
        $check =  GlobalCatUnavailable::where(['bunit_code' => $request->bunit_code, 'category_id' => $request->category])->exists();
        if ($check) {
            $delete = GlobalCatUnavailable::where(['bunit_code' => $request->bunit_code, 'category_id' => $request->category])->delete();
            if ($delete) {
                return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
            } else {
                return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
        } else {
            $save = GlobalCatUnavailable::create([
                'bunit_code' => $request->bunit_code, 'category_id' => $request->category,
                'created_at'             => date('Y-m-d H:i:s'),
                'updated_at'             => date('Y-m-d H:i:s'),
            ]);
            if ($save) {
                return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
            } else {
                return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
        }
    }
    public function change_photo(Request $request)
    {
        $image = $request->file('image');
        $imageName = 'bu_' . $request->id . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images/business_units');
        $image->move($path, $imageName);

        if (file_exists($path . $imageName)) {
            @unlink($path . $imageName);
        }

        $save =  DB::table('locate_business_units')->where('locate_business_units.bunit_code', $request->id)->update([
            'logo'                   => 'images/business_units/' . $imageName,
            'updated_at'             => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Uploaded successfully.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
