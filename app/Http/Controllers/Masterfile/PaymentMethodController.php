<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    public function show_payment_method(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('payment_methods')->orderBy('payment_methods.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('payment_methods.payment_gateway', 'like', '%' . $searchValue . '%')
                    ->orWhere('payment_methods.discription', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function update_payment_method(Request $request)
    {
        $this->validate($request, [
            'payment_method'        => ['required'],
            'payment_description'   => ['required'],

        ], [
            'payment_method.required'       => 'Payment method must not be empty.',
            'payment_description.required'  => 'Description must not be empty.'
        ]);
        $save = DB::table('payment_methods')->whereId($request->id)->update([
            'payment_gateway'           => strtoupper($request->payment_method),
            'discription'               => $request->payment_description,
            'updated_at'                => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function create_payment_method(Request $request)
    {
        $this->validate($request, [
            'payment_method'        => ['required'],
            'payment_description'   => ['required'],

        ], [
            'payment_method.required'       => 'Payment method must not be empty.',
            'payment_description.required'  => 'Description must not be empty.'
        ]);
        $save = DB::table('payment_methods')->insert([
            'payment_gateway'           => strtoupper($request->payment_method),
            'discription'               => $request->payment_description,
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s'),
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
        $save = DB::table('payment_methods')->whereId($request->id)->update([
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
