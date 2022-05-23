<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $guarded = [];
    protected $table = 'locate_tenants';
    public $timestamps = true;

    public function businessunit()
    {
        return $this->belongsTo('App\BusinessUnit', 'bunit_code', 'bunit_code');
    }
    public function GlobalCategory()
    {
        return $this->belongsTo('App\GlobalCategory', 'global_cat_id', 'id');
    }

    public function contact_nums()
    {
        return $this->hasMany('App\TenantContact', 'tenant_id', 'tenant_id');
    }
}
