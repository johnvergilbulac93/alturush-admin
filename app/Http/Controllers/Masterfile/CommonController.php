<?php

namespace App\Http\Controllers\Masterfile;

use App\GlobalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function get_selected_tenant(Request $request)
    {
        return  DB::table('locate_tenants')->where('locate_tenants.bunit_code', $request->id)->get();
    }
    public function province()
    {
        return DB::table('province')->where(['status' => true])->get();
    }
    public function town()
    {
        return  DB::table('towns')->where(['status' => true])->get();
    }
    public function barangay()
    {
        return  DB::table('barangays')->where(['status' => true])->get();
    }
    public function transportation()
    {
        return  DB::table('gc_transportations')->where(['status' => true])->get();
    }
    public function store()
    {
        return DB::table('locate_business_units')->where(['active' => true])->get();
    }
    public function price_group()
    {
        return  DB::table('gc_price_groups')->get();
    }
    public function department()
    {
        return DB::table('gc_departments')->where(['status' => true])->get();
    }
    public function global_category()
    {
        return GlobalCategory::with(['check_cat'])->where(['status' => true])->get();
    }
    public function discount()
    {
        return DB::table('discount_lists')->where(['status' => true])->get();
    }
    public function range_level()
    {
        return DB::table('fd_location_ranges')->where(['status' => true])->get();
    }
}
