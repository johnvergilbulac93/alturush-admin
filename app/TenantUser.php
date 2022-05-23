<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class TenantUser extends Model
{
    protected $guarded = [];
    protected $table = 'tenant_users';
    public $timestamps = true;

    public function tenant()
    {
        return $this->belongsTo('App\Tenant', 'tenant_id', 'tenant_id')
            ->join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code');
    }
    protected $hidden = [
        'password', 'email', 'remember_token'
    ];
}
