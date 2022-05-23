<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_tenant extends Model
{
    protected $fillable = [
        'bunit_code', 'dept_id','status','logo','additional_charge','created_at'
    ];

    protected $table = 'gc_tenants';

    public $timestamps = false;
}
