<?php

// namespace App\Http\Controllers\API;
namespace App\Http\Controllers\Masterfile;

use App\User;
use App\UserType;
use App\TenantUser;
use App\gc_employee;
use App\gc_usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\UserFood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get_users(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_users')
            ->join('user_types', 'gc_users.usertype_id', '=', 'user_types.id')
            ->join('locate_business_units', 'gc_users.bunit_code', '=', 'locate_business_units.bunit_code')
            ->select(
                'gc_users.id',
                'gc_users.emp_id',
                'gc_users.emp_id',
                'gc_users.bunit_code',
                'gc_users.usertype_id',
                'user_types.usertype',
                'gc_users.name',
                'gc_users.username',
                'locate_business_units.business_unit',
                'gc_users.created_at',
                'gc_users.status',
                'gc_users.inactivity_date',

            )
            ->orderBy('gc_users.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function usertype()
    {
        return gc_usertype::where('type', '=', 2)->orwhere('type', '=', 0)->get();
    }

    public function create_good_user(Request $request)
    {
        if ($request->password) {
            $this->validate($request, [
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'string', 'max:255', 'unique:gc_users,username'],
                'emp_id'        => ['required'],
                'usertype'      => ['required'],
                'store'         => ['required'],
                'password'      => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/']
            ], [
                'store.required' => "Please select a store",
                'usertype.required' => "Please select a usertype"
            ]);
        } else {
            $this->validate($request, [
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'string', 'max:255', 'unique:gc_users,username'],
                'emp_id'        => ['required'],
                'usertype'      => ['required'],
                'store'         => ['required'],
            ], [
                'store.required' => "Please select a store",
                'usertype.required' => "Please select a usertype"
            ]);
        }
        $usertype = [6, 7, 8, 12, 14, 15];
        $default_password = env('APP_DEFAULT_PASS');
        $password = '';
        $password2 = '';
        $status = false;
        if ($request->password) {
            $password = Hash::make($request->password);
            $password2 = md5($request->password);
        } else {
            $password = Hash::make($default_password);
            $password2 = md5($default_password);
        }
        if (in_array($request->usertype, $usertype)) {
            $status  = true;
        } else {
            $status  = false;
        }
        $save =  User::create([
            'name'              => $request->name,
            'username'          => $request->username,
            'password'          => $password,
            'password2'         => $password2,
            'usertype_id'       => $request->usertype,
            'bunit_code'        => $request->store,
            'emp_id'            => $request->emp_id,
            'isAdmin'           => $status,
            'status'           => true,
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }

    public function update_user(Request $request)
    {

        $usertype = [6, 7, 8, 12, 14, 15];
        $status = false;
        if (in_array($request->usertype, $usertype)) {
            $status = true;
        } else {
            $status = false;
        }
        $save = User::where('id', $request->id)->update([
            'name'               => $request->name,
            'username'           => $request->username,
            'usertype_id'        => $request->usertype,
            'bunit_code'         => $request->store,
            'emp_id'             => $request->emp_id,
            'isAdmin'            => $status
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function employees(Request $request)
    {
        if ($request->employee) {
            return gc_employee::where('name', 'like', '%' . $request->employee . '%')->get();
        }
    }
    public function change_password(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password|confirmed',
        ]);
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password),
                'password2' => md5($request->new_password)
            ])->save();
        } else {

            $custom_error = array(
                'old_password' => ['Password does not match']
            );
            return response()->json([
                'errors' => $custom_error,
            ], 422);
        }
    }
    public function change_username(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $this->validate($request, [
            'old_username' => 'required',
            'new_username' => 'required|different:old_username|unique:gc_users,username',
        ]);

        if ($request->old_username === $user->username) {
            $user->fill([
                'username' => $request->new_username,
            ])->save();
        } else {

            $custom_error = array(
                'old_username' => ['Username does not match']
            );
            return response()->json([
                'errors' => $custom_error,
            ], 422);
        }
    }
    public function profile_image(Request $request)
    {
        $this->validate($request, [
            'profile_image'      => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $userImage = $request->file('profile_image');
        $imageName = Auth::user()->username . '.' . $userImage->getClientOriginalExtension();

        $path = public_path() . '/USER-PROFILE/';

        // $path = '../admins.alturush.com/USER-PROFILE/';\
        $userImage->move($path, $imageName);

        if (file_exists($path)) {
            @unlink($path);
        }

        User::whereId(Auth::user()->id)->update([
            'image' => $imageName
        ]);
    }
    public function user_status(Request $request)
    {
        if ($request->status === 1) {
            $save = User::whereId($request->id)->update([
                'status' => 0,
                'inactivity_date' => date('Y-m-d H:i:s')
            ]);
        } else {
            $save =  User::whereId($request->id)->update([
                'status' => 1,
                'inactivity_date' => null
            ]);
        }

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function get_tenant_usertype()
    {
        return UserType::where(['usertype_class' => 'Tenant', 'status' => true])->get();
    }
    public function food_usertype(Request $request)
    {
        return UserType::where(['usertype_class' => $request->type, 'status' => true])->get();
    }
    public function get_tenant_users(Request $request)
    {

        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = DB::table('tenant_users')
            ->join('locate_tenants', 'tenant_users.tenant_id', '=', 'locate_tenants.tenant_id')
            ->join('locate_business_units', 'locate_tenants.bunit_code', '=', 'locate_business_units.bunit_code')
            ->select(
                'tenant_users.id',
                'tenant_users.name',
                'tenant_users.user_type',
                'tenant_users.username',
                'tenant_users.active',
                'tenant_users.image',
                'tenant_users.tenant_id',
                'locate_tenants.tenant',
                'locate_tenants.acroname',
                'locate_tenants.logo',
                'locate_business_units.business_unit',
                'locate_business_units.bunit_code',


            )->orderBy('tenant_users.id', $dir);

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('tenant_users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('locate_tenants.tenant', 'like', '%' . $searchValue . '%')
                    ->orWhere('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }

    public function update_user_tenant(Request $request)
    {
        $this->validate($request, [
            'store'     => 'required',
            'tenant'    => 'required',
            'name'      => 'required',
            'username'  => 'required',
            'usertype'  => 'required',
        ]);

        $save =  TenantUser::whereId($request->id)->update([
            'tenant_id' => $request->tenant,
            'name'      => $request->name,
            'username'  => $request->username,
            'user_type' => $request->usertype
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function create_user_tenant(Request $request)
    {
        if ($request->password) {
            $this->validate($request, [
                'password'      => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'max:255', 'unique:tenant_users,username'],
                'usertype'      => ['required'],
                'tenant'        => ['required'],
                'store'         => ['required'],
            ]);
        } else {
            $this->validate($request, [
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'max:255', 'unique:tenant_users,username'],
                'usertype'      => ['required'],
                'tenant'        => ['required'],
                'store'         => ['required'],
            ]);
        }

        $password = '';
        $picName = '';

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = 'tenant_' . $request->username . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/tenant_users');
            $image->move($path, $imageName);
            if (file_exists($path . $imageName)) {
                @unlink($path . $imageName);
            }
            $picName = 'images/tenant_users/' . $imageName;
        } else {
            $picName = 'images/tenant_users/' . 'noimage.png';
        }
        if ($request->password) {

            $password = Hash::make($request->password);
        } else {
            $password = Hash::make(env('APP_DEFAULT_PASS'));
        }
        $save =  TenantUser::insert([
            'name'      => $request->name,
            'username'  => $request->username,
            'tenant_id' => $request->tenant,
            'user_type' => $request->usertype,
            'password'  => $password,
            'image'     =>  $picName,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function tenant_reset_password(Request $request)
    {
        $reset = TenantUser::whereId($request->id)->update([
            'password'  => Hash::make(env('APP_DEFAULT_PASS')),
        ]);

        if ($reset) {
            return ['msg' => 'Password reset successfully.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_tenant_user_status(Request $request)
    {

        if ($request->status == 1) {
            $status = array(
                'active'    => 0
            );
        } else {
            $status = array(
                'active'    => 1
            );
        }
        $save = TenantUser::whereId($request->id)->update($status);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_system_user_status(Request $request)
    {
        if ($request->status == 1) {
            $status = array(
                'active'    => 0
            );
        } else {
            $status = array(
                'active'    => 1
            );
        }
        $save =  DB::table('users')->whereId($request->id)->update($status);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_tenant_user_photo(Request $request)
    {
        $image = $request->file('image');
        $imageName = 'tenant_' . $request->id . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images/tenant_users');

        $image->move($path, $imageName);

        if (file_exists($path . $imageName)) {
            @unlink($path . $imageName);
        }
        $save = TenantUser::whereId($request->id)->update([
            'image'     => 'images/tenant_users/' . $imageName,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Picture updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function get_system_users(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = UserFood::orderBy('id', $dir);

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function get_default_data(Request $request)
    {
        if ($request->type == 'System') {
            $num = UserFood::max('id');
            if ($num == null) {
                $num = 0;
            }
            $default_username = ['username' => sprintf('%05d', intval($num) + 1) . "-" . date('Y')];
            return $default_username;
        } else {
            $num = TenantUser::max('id');
            if ($num == null) {
                $num = 0;
            }
            $message = ['username' => sprintf('%05d', intval($num) + 1) . "-" . date('Y')];;
            return response()->json($message);
        }
    }
    public function create_system_user(Request $request)
    {
        if ($request->password) {
            $this->validate($request, [
                'password'      => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'max:255', 'unique:users,username'],
                'usertype'      => ['required'],
            ]);
        } else {
            $this->validate($request, [
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'max:255', 'unique:users,username'],
                'usertype'      => ['required'],
            ]);
        }

        $password = '';
        $picName = '';

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = 'system_user_' . $request->username . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/system_users');
            $image->move($path, $imageName);
            if (file_exists($path . $imageName)) {
                @unlink($path . $imageName);
            }
            $picName = 'images/system_users/' . $imageName;
        } else {
            $picName = 'images/system_users/' . 'noimage.png';
        }

        if ($request->password) {
            $password = Hash::make($request->password);
        } else {
            $password = Hash::make(env('APP_DEFAULT_PASS'));
        }
        $save = DB::table('users')->insert([
            'name'          => $request->name,
            'username'      => $request->username,
            'user_type'     => $request->usertype,
            'image'         => $picName,
            'password'      => $password,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_system_user(Request $request)
    {
        $this->validate($request, [
            'name'          => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string'],
            'usertype'      => ['required'],
        ]);
        $save = DB::table('users')->whereId($request->id)->update([
            'name'          => $request->name,
            'username'      => $request->username,
            'user_type'     => $request->usertype,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_system_user_photo(Request $request)
    {
        $image = $request->file('image');
        $imageName = 'system_users_' . $request->id . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images/system_users');

        $image->move($path, $imageName);

        if (file_exists($path . $imageName)) {
            @unlink($path . $imageName);
        }

        $save =  DB::table('users')->whereId($request->id)->update([
            'image'     => 'images/system_users/' . $imageName,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if ($save) {
            return ['msg' => 'Picture updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function system_user_reset_password(Request $request)
    {
        $reset =  DB::table('users')->whereId($request->id)->update([
            'password'  => Hash::make(env('APP_DEFAULT_PASS')),
        ]);
        if ($reset) {
            return ['msg' => 'Password successfully reset.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function userrole(Request $request)
    {
        $result = array();
        $data = UserType::where(['usertype_class' => $request->type, 'status' => true])->orderBy('usertype', 'asc')->get();
        foreach ($data as $value) {
            $res = UserFood::where('id', $request->id)->get()->first();
            $result[] = ['id' => $value['id'], "usertype" => $value['usertype'], 'stat' => $res->hasRole($value['id']), 'userdata' => $res];
        }
        return response()->json($result);
    }
    public function save_user_role(Request $request)
    {
        $roleCheck =  DB::table('user_roles')->where(['usertype_id' => $request->usertype, 'user_id' => $request->user_id])->get()->first();

        if ($roleCheck) {
            if ($request->status == true) {
                $status = true;
                $msg = 'saved.';
            } else {
                $status = false;
                $msg = 'removed.';
            }

            $update =  DB::table('user_roles')->where([
                'usertype_id' => $request->usertype,
                'user_id' => $request->user_id
            ])->update([
                'usertype_id' => $request->usertype,
                'user_id' => $request->user_id,
                'status' => $status
            ]);
            if ($update) {
                $message = ['msg' => 'User role setup is successfully ' . $msg, 'status' => 'success', 'title' => 'Success'];
            } else {
                $message = ['msg' => 'Oops, something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }

            return $message;
        } else {

            $createRole = DB::table('user_roles')->insert(['usertype_id' => $request->usertype, 'user_id' => $request->user_id]);

            if ($createRole) {
                $message = ['msg' => 'User role setup is successfully saved.', 'status' => 'success', 'title' => 'Success'];
            } else {
                $message = ['msg' => 'Oops, something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
            return $message;
        }
    }
    public function goods_user_reset_password(Request $request)
    {
        $reset =  User::where('id', $request->id)->update([
            'password'      => Hash::make(env('APP_DEFAULT_PASS')),
            'password2'     => md5(env('APP_DEFAULT_PASS'))
        ]);
        if ($reset) {
            return ['msg' => 'Password successfully reset.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
