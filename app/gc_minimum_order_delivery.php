<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_minimum_order_delivery extends Model
{
    protected $table = 'gc_minimum_order_deliveries';
    
    protected $fillable = [
        'bunit_code', 'department_id','amount','status'
    ];
    



}
