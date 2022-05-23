<?php

namespace App\Http\Controllers\Masterfile;

use App\GlobalCategory;
use App\GlobalDiscountSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GlobalDiscountController extends Controller
{
    public function show_global_discount(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = GlobalDiscountSetup::join('discount_lists', 'discount_lists.id', 'global_discount_setups.discount_id')
            ->join('global_categories', 'global_categories.id', 'global_discount_setups.global_cat_id')
            ->select(
                'global_discount_setups.status as global_disc_stat',
                'global_discount_setups.id as global_disc_id',
                'global_discount_setups.*',
                'discount_lists.*',
                'global_categories.*'
            )->orderBy('global_categories.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('global_categories.category', 'like', '%' . $searchValue . '%')
                    ->orWhere('discount_lists.discount_name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_global_discount(Request $request)
    {
        $this->validate($request, [
            'global_category'      => ['required'],
            'discount'              => ['required'],

        ], [
            'global_category.required' => 'Please select a global category.',
            'discount.required'   => 'Please select a discount name.'
        ]);

        $checking_data =  DB::table('global_discount_setups')
            ->where('global_discount_setups.global_cat_id', $request->global_category)
            ->where('global_discount_setups.discount_id',     $request->discount)
            ->exists();

        if (!$checking_data) {
            $save = DB::table('global_discount_setups')->insert([
                'global_cat_id'             => $request->global_category,
                'discount_id'               => $request->discount,
                'created_at'                => date('Y-m-d H:i:s'),
                'updated_at'                => date('Y-m-d H:i:s'),
            ]);
            if ($save) {
                return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
            } else {
                return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    }
    public  function update_global_discount(Request $request)
    {
        $this->validate($request, [
            'global_category'      => ['required'],
            'discount'              => ['required'],

        ], [
            'global_category.required' => 'Please select a global category.',
            'discount.required'   => 'Please select a discount name.'
        ]);
        $save = DB::table('global_discount_setups')->whereId($request->id)->update([
            'global_cat_id'             => $request->global_category,
            'discount_id'               => $request->discount,
            'updated_at'                => date('Y-m-d H:i:s'),
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
        $save = DB::table('global_discount_setups')->whereId($request->id)->update([
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
