<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function show_discount(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('discount_lists')->orderBy('discount_lists.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('discount_lists.discount_name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_discount(Request $request)
    {
        $this->validate($request, [
            'discount'      => ['required', 'unique:discount_lists,discount_name'],
        ], [
            'discount.required' => 'Discount name must not be empty.'
        ]);

        $save = DB::table('discount_lists')->insert([
            'discount_name'          => $request->discount,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_discount(Request $request)
    {
        $this->validate($request, [
            'discount'      => ['required'],
        ], [
            'discount.required' => 'Discount name must not be empty.'
        ]);

        $save = DB::table('discount_lists')->whereId($request->id)->update([
            'discount_name'          => $request->discount,
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
        $save = DB::table('discount_lists')->whereId($request->id)->update([
            'status'                 => $status,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
