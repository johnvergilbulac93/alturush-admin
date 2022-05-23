<?php

namespace App\Http\Controllers\API;

use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function get_selected_tenant(Request $request)
    {
        return Tenant::where('bunit_code', $request->id)->get();
    }
}
