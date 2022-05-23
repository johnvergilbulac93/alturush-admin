<?php

namespace App\Http\Controllers\Masterfile;

use App\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTypeController extends Controller
{
    public function show_usertype(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  UserType::where(['usertype_class' => $request->type])->orderBy('id', $dir);
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('usertype', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }

    public function create_usertype_tenant(Request $request)
    {
        $this->validate($request, [
            'usertype'  => ['required', 'string']
        ]);
        $save = UserType::create([
            'usertype'          => $request->usertype,
            'usertype_class'    => $request->type
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_usertype_tenant(Request $request)
    {
        $save =  UserType::whereId($request->id)->update([
            'usertype'   =>  strtoupper($request->usertype)
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function create_system_usertype(Request $request)
    {
        $this->validate($request, [
            'usertype'  => ['required', 'string']
        ]);
        $save =  UserType::create([
            'usertype'          => $request->usertype,
            'usertype_class'    => $request->type
        ]);

        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_system_usertype(Request $request)
    {
        $save =  UserType::whereId($request->id)->update([
            'usertype'   =>  strtoupper($request->usertype)
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
        $save = UserType::whereId($request->id)->update([
            'status'            => $status,
            'updated_at'        => date('Y-m-d H:i:s'),

        ]);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
