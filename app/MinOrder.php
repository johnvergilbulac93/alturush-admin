<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MinOrder extends Model
{
    protected $table = 'tbl_min_orders';
    public function tenant()
    {
        return $this->belongsTo("App\Tenant", "tenant_id", "tenant_id")
            ->join("locate_business_units", "locate_business_units.bunit_code", "locate_tenants.bunit_code");
    }
}
