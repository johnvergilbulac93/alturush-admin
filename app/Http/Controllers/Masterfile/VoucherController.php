<?php

namespace App\Http\Controllers\masterfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function show(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('voucher_categories')->orderBy('id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('voucher_categories.voucher_category', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'voucher'      => ['required', 'unique:voucher_categories,voucher_category'],
        ], [
            'voucher.required' => 'Voucher name must not be empty.',
            'voucher.unique'   => 'Voucher name is already in use.'
        ]);
        $save = DB::table('voucher_categories')->insert([
            'voucher_category' => ucfirst($request->voucher),
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'voucher'      => ['required'],
        ], [
            'voucher.required' => 'Voucher name must not be empty.'
        ]);
        $save = DB::table('voucher_categories')->where('voucher_categories.id', $request->id)->update([
            'voucher_category' => ucfirst($request->voucher),
            'updated_at'       => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function status(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save = DB::table('voucher_categories')->where('voucher_categories.id', $request->id)->update([
            'status'    => $status,
            'updated_at'       => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
