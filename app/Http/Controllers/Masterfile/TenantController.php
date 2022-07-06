<?php

namespace App\Http\Controllers\Masterfile;

use App\gc_tenant;
use App\TenantFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    public function show_goods_tenant(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query =  DB::table('gc_tenants')
            ->join('locate_business_units', 'gc_tenants.bunit_code', '=', 'locate_business_units.bunit_code')
            ->join('gc_departments', 'gc_tenants.dept_id', '=', 'gc_departments.dept_id')
            ->select(
                'locate_business_units.business_unit',
                'gc_departments.name',
                'gc_tenants.tenant_id',
                'gc_tenants.status',
                'gc_tenants.bunit_code',
                'gc_tenants.dept_id'
            )
            ->orderBy('gc_tenants.tenant_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_departments.name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function save_goods_tenant(Request $request)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'    => 'required',
        ], [
            'store.required'            => 'Please select a store',
            'department.required'       => 'Please select a department'
        ]);
        $checking_data =  gc_tenant::where('bunit_code', $request->get('store'))
            ->where('dept_id', $request->get('department'))
            ->exists();
        if (!$checking_data) {
            $save =  gc_tenant::create([
                'bunit_code'    => $request->store,
                'dept_id'       => $request->department,
                'status'        => 1,
                'created_at'             => date('Y-m-d H:i:s'),
                'updated_at'             => date('Y-m-d H:i:s'),
            ]);
            if ($save) {
                return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
            } else {
                return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
            }
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    }
    public function update_goods_tenant(Request  $request)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'    => 'required',
        ], [
            'store.required'            => 'Please select a store',
            'department.required'       => 'Please select a department'
        ]);
        $save = gc_tenant::where('tenant_id', $request->id)->update([
            'bunit_code'    => $request->store,
            'dept_id'       => $request->department,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_status_goods_tenant(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save = gc_tenant::where('tenant_id', $request->id)->update([
            'status'    => $status,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function show_foods_tenant(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = TenantFood::with(['businessunit', 'GlobalCategory', 'contact_nums'])->orderBy('tenant_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('tenant', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function save_foods_tenant(Request $request)
    {

        $this->validate($request, [
            'category'      => 'required',
            'store'         => 'required',
            'tenant_name'   => 'required',
            'acroname'      => 'required',

        ], [
            'category.required'             => 'Please select a category',
            'store.required'                => 'Please select a business unit.',
            'tenant_name.required'          => 'Tenant name must not be empty.',
            'acroname.required'             => 'Acroname must not be empty.'
        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = 'tenant_' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/tenants');
            $image->move($path, $imageName);
            if (file_exists($path . $imageName)) {
                @unlink($path . $imageName);
            }
            $picName = 'images/tenants/' . $imageName;
        } else {
            $picName = 'images/tenants/' . 'noimage.png';
        }
        $save = TenantFood::create([
            'global_cat_id' => $request->category,
            'bunit_code' => $request->store,
            'tenant' => $request->tenant_name,
            'acroname' => $request->acroname,
            'logo'      => $picName,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_foods_tenant(Request  $request)
    {
        $this->validate($request, [
            'category'      => 'required',
            'store'         => 'required',
            'tenant_name'   => 'required',
            'acroname'      => 'required',

        ], [
            'category.required'             => 'Please select a category',
            'store.required'                => 'Please select a business unit.',
            'tenant_name.required'          => 'Tenant name must not be empty.',
            'acroname.required'             => 'Acroname must not be empty.'
        ]);
        $save = TenantFood::where('tenant_id', $request->id)->update([
            'global_cat_id'          => $request->category,
            'bunit_code'             => $request->store,
            'tenant'                 => $request->tenant_name,
            'acroname'               => strtoupper($request->acroname),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_status_foods_tenant(Request $request)
    {
        if ($request->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $save = TenantFood::where('tenant_id', $request->id)->update([
            'active'    => $status,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function show_contacts_tenant_foods(Request $request)
    {
        return DB::table('tenant_contacts')->where('tenant_contacts.tenant_id', $request->id)->get();
    }
    public function save_contacts_tenant_foods(Request $request)
    {
        $this->validate($request, [
            'contact_type'   => 'required',
            'contact_num'    => 'required|string|min:11',
        ], [
            'contact_type.required'            => 'Please select a contact type',
            'contact_num.required'             => 'Contact number must not empty.',
            'contact_num.min'                  => 'The contact num must be at least 11 numbers.'
        ]);


        $save =  DB::table('tenant_contacts')->insert([
            'tenant_id'              => $request->tenant_id,
            'contact_type'           => $request->contact_type,
            'contact_num'            => $request->contact_num,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function remove_contacts_tenant_foods(Request $request)
    {
        $save =  DB::table('tenant_contacts')->where('tenant_contacts.id', $request->id)->delete();
        if ($save) {
            return ['msg' => 'Successfully deleted.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_image_tenant_foods(Request $request)
    {

        $image = $request->file('image');
        $imageName = 'tenant_' . time() . '.' . $image->getClientOriginalExtension();

        $path = public_path('/images/tenants');

        $image->move($path, $imageName);
        if (file_exists($path . $imageName)) {
            @unlink($path . $imageName);
        }
        $save = TenantFood::where('tenant_id', $request->id)->update([
            'logo'              => 'images/tenants/' . $imageName,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Logo successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
