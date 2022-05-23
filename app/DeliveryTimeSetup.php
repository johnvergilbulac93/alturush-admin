<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryTimeSetup extends Model
{
    protected $table = 'delivery_time_setups';

    public function bunitgroup()
    {
        return $this->belongsTo('App\BunitGroup', 'bu_group_id', 'id');
    }
}   
